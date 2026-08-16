#!/bin/bash
# Asef Sondaj — Adaptation Layer install script
# Idempotent: safe to run multiple times

set -e

BAGISTO_ROOT="${BAGISTO_ROOT:-$HOME/bagisto}"
PHP_BIN="${PHP_BIN:-/opt/alt/php83/usr/bin/php}"
COMPOSER_BIN="${COMPOSER_BIN:-$HOME/bin/composer}"

echo "==> Asef Adaptation Layer Deployment"
echo "    Bagisto root: $BAGISTO_ROOT"
echo "    PHP:          $PHP_BIN"
echo "    Composer:     $COMPOSER_BIN"

if [ ! -d "$BAGISTO_ROOT" ]; then
    echo "!! Bagisto not found at $BAGISTO_ROOT"
    exit 1
fi

cd "$BAGISTO_ROOT"

# ---------- 1) Ensure package is required in root composer.json ----------
# Bagisto uses path repository (packages/*/*), so we require our package to
# trigger composer's path-repo mechanism. Do NOT duplicate PSR-4 in root —
# the package's own composer.json handles autoloading via the path repo.
echo "==> 1/5 Patching composer.json require"
$PHP_BIN -r '
$file = "composer.json";
$data = json_decode(file_get_contents($file), true);

// Clean any accidental duplicate PSR-4 entries from earlier install attempts
foreach (["AsefSondaj\\\\AdaptationLayer\\\\", "AsefSondaj\\\\Theme\\\\"] as $ns) {
    if (isset($data["autoload"]["psr-4"][$ns])) unset($data["autoload"]["psr-4"][$ns]);
}

// Remove Theme require (reverted — Faz 3 rollback)
if (isset($data["require"]["asefsondaj/theme"])) {
    unset($data["require"]["asefsondaj/theme"]);
    echo "    removed require asefsondaj/theme (reverted)\n";
}

// Ensure Adaptation Layer require (path repo will resolve it from packages/)
$data["require"]["asefsondaj/adaptation-layer"] = "@dev";

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
echo "    require asefsondaj/adaptation-layer ensured\n";
'

# ---------- 2) Ensure provider registered in bootstrap/providers.php ----------
echo "==> 2/5 Patching bootstrap/providers.php"
PROVIDERS="bootstrap/providers.php"
if [ ! -f "$PROVIDERS" ]; then
    echo "!! $PROVIDERS not found"
    exit 1
fi

# Clean up: remove AsefThemeServiceProvider (reverted Faz 3) if present
$PHP_BIN -r "
    \$file = 'bootstrap/providers.php';
    \$c = file_get_contents(\$file);
    // Strip Faz 3 Theme references (rollback cleanup)
    \$c = preg_replace('/\\n?use AsefSondaj\\\\\\\\Theme\\\\\\\\Providers\\\\\\\\AsefThemeServiceProvider;.*?\\n/', \"\\n\", \$c);
    \$c = preg_replace('/\\s*AsefThemeServiceProvider::class,\\s*\\n/', \"\\n\", \$c);
    file_put_contents(\$file, \$c);
"

if grep -q "AdaptationServiceProvider" "$PROVIDERS"; then
    echo "    Adaptation provider already registered — skipped"
else
    $PHP_BIN -r "
        \$file = 'bootstrap/providers.php';
        \$c = file_get_contents(\$file);
        if (strpos(\$c, 'AsefSondaj\\\\AdaptationLayer\\\\Providers\\\\AdaptationServiceProvider') === false) {
            \$c = preg_replace('/(<\\?php\\s*)/', \"\$1\\nuse AsefSondaj\\\\AdaptationLayer\\\\Providers\\\\AdaptationServiceProvider;\\n\", \$c, 1);
        }
        \$c = preg_replace('/return\\s*\\[/', \"return [\\n    AdaptationServiceProvider::class,\", \$c, 1);
        file_put_contents(\$file, \$c);
        echo '    Adaptation provider registered' . PHP_EOL;
    "
fi

# ---------- 3) Composer install/update for the package + dump-autoload ----------
echo "==> 3/5 Composer update asefsondaj/adaptation-layer + dump-autoload"
$COMPOSER_BIN update asefsondaj/adaptation-layer --no-scripts --no-interaction 2>&1 || $COMPOSER_BIN require asefsondaj/adaptation-layer:@dev --no-scripts --no-interaction
$COMPOSER_BIN dump-autoload -o --no-scripts

# ---------- 3.5) Migrate + seed Asef catalog (idempotent) ----------
echo "==> 3.5 Asef catalog migrate + seed"
$PHP_BIN artisan migrate --path=packages/AsefSondaj/AdaptationLayer/src/Database/Migrations --force
$PHP_BIN artisan db:seed --class="AsefSondaj\\AdaptationLayer\\Database\\Seeders\\AsefCatalogSeeder" --force 2>&1 || echo "    (seed skipped / failed — non-blocking)"

# ---------- 4) Cache clear ----------
echo "==> 4/5 Cache clear"
$PHP_BIN artisan optimize:clear
# Explicit view compilation dir wipe — Bagisto sometimes leaves stale compiled Blade
# files even after optimize:clear (e.g., adaptation views retain old $products/$filtered)
rm -rf storage/framework/views/*.php 2>/dev/null || true
$PHP_BIN artisan view:clear
# Spatie Response Cache — Bagisto caches entire HTML responses per URL. If we
# do not clear this, /search?cat=* returns the FIRST cached variant regardless
# of the query string, and users see wrong products / stale filter results.
$PHP_BIN artisan responsecache:clear 2>/dev/null || true

# ---------- 5) Copy logo + favicon + webhook to public/ ----------
echo "==> 5/7 Publishing logo + favicon + webhook"
PKG_ASSETS="$PWD/packages/AsefSondaj/AdaptationLayer/src/Resources/assets"
if [ -f "$PKG_ASSETS/images/logo.png" ]; then
    cp -f "$PKG_ASSETS/images/logo.png" "$BAGISTO_ROOT/public/asef-logo.png"
    echo "    asef-logo.png -> public/"
fi
if [ -f "$PKG_ASSETS/images/favicon.ico" ]; then
    cp -f "$PKG_ASSETS/images/favicon.ico" "$BAGISTO_ROOT/public/favicon.ico"
    echo "    favicon.ico -> public/"
fi

# Homepage assets: brand photos + page CSS/JS -> public/asef/
mkdir -p "$BAGISTO_ROOT/public/asef"
if [ -d "$PKG_ASSETS/images/asef" ]; then
    cp -f "$PKG_ASSETS/images/asef/"*.jpg "$BAGISTO_ROOT/public/asef/" 2>/dev/null || true
    cp -f "$PKG_ASSETS/images/asef/"*.png "$BAGISTO_ROOT/public/asef/" 2>/dev/null || true
    echo "    brand photos -> public/asef/"
fi
if [ -f "$PKG_ASSETS/css/asef-home.css" ]; then
    cp -f "$PKG_ASSETS/css/asef-home.css" "$BAGISTO_ROOT/public/asef/asef-home.css"
    echo "    asef-home.css -> public/asef/"
fi
if [ -f "$PKG_ASSETS/js/asef-home.js" ]; then
    cp -f "$PKG_ASSETS/js/asef-home.js" "$BAGISTO_ROOT/public/asef/asef-home.js"
    echo "    asef-home.js -> public/asef/"
fi

# Self-update webhook.php in public/ (keeps webhook code fresh w/o manual copy)
# Preserves the SECRET line from the existing installed webhook.
WEBHOOK_SRC="$PWD/packages/AsefSondaj/deploy-webhook.php"
WEBHOOK_DST="$BAGISTO_ROOT/public/asef-deploy-webhook.php"
if [ -f "$WEBHOOK_SRC" ]; then
    if [ -f "$WEBHOOK_DST" ]; then
        # Extract current SECRET from installed webhook, apply to new one
        CURRENT_SECRET=$(grep -oP "SECRET\s*=\s*'\K[^']+" "$WEBHOOK_DST" | head -1)
        cp -f "$WEBHOOK_SRC" "$WEBHOOK_DST"
        if [ -n "$CURRENT_SECRET" ] && [ "$CURRENT_SECRET" != "asef-deploy-2026-token" ]; then
            sed -i "s|asef-deploy-2026-token|$CURRENT_SECRET|" "$WEBHOOK_DST"
            echo "    webhook self-updated (secret preserved)"
        else
            echo "    webhook self-updated (no custom secret yet — set one from cPanel)"
        fi
    else
        cp -f "$WEBHOOK_SRC" "$WEBHOOK_DST"
        echo "    webhook installed at public/asef-deploy-webhook.php (default token — CHANGE IT)"
    fi
fi

# ---------- 6) Inject storefront CSS + JS into Bagisto core_config ----------
echo "==> 6/7 Injecting storefront CSS + JS via core_config"
CSS_FILE="$PKG_ASSETS/css/asef-storefront.css"
JS_FILE="$PKG_ASSETS/js/asef-storefront.js"

$PHP_BIN "$BAGISTO_ROOT/artisan" tinker --execute "
    \$now = now();

    // CSS injection
    if (file_exists('$CSS_FILE')) {
        \$css = file_get_contents('$CSS_FILE');
        \$existsCss = DB::table('core_config')->where('code', 'general.content.custom_scripts.custom_css')->first();
        if (\$existsCss) {
            DB::table('core_config')->where('code', 'general.content.custom_scripts.custom_css')->update(['value' => \$css, 'updated_at' => \$now]);
        } else {
            // channel_code MUST match the current channel — a NULL row is
            // ignored by core()->getConfigData() (verified in local test).
            DB::table('core_config')->insert([
                'code' => 'general.content.custom_scripts.custom_css',
                'value' => \$css,
                'channel_code' => 'default',
                'locale_code' => null,
                'created_at' => \$now,
                'updated_at' => \$now,
            ]);
        }
        echo 'CSS injected (' . strlen(\$css) . ' bytes)' . PHP_EOL;
    }

    // JS injection
    if (file_exists('$JS_FILE')) {
        \$js = file_get_contents('$JS_FILE');
        \$existsJs = DB::table('core_config')->where('code', 'general.content.custom_scripts.custom_javascript')->first();
        if (\$existsJs) {
            DB::table('core_config')->where('code', 'general.content.custom_scripts.custom_javascript')->update(['value' => \$js, 'updated_at' => \$now]);
        } else {
            DB::table('core_config')->insert([
                'code' => 'general.content.custom_scripts.custom_javascript',
                'value' => \$js,
                'channel_code' => 'default',
                'locale_code' => null,
                'created_at' => \$now,
                'updated_at' => \$now,
            ]);
        }
        echo 'JS injected (' . strlen(\$js) . ' bytes)' . PHP_EOL;
    }
" 2>&1 || echo "    (config injection skipped)"

# ---------- 7) Config cache ----------
echo "==> 7/7 Config cache"
$PHP_BIN artisan config:cache

echo ""
echo "🎉 Asef Adaptation Layer deployed successfully"
echo ""
echo "Test:"
echo "  https://www.asefsondaj.com/checkout    → should redirect to /"
echo "  https://www.asefsondaj.com/customer/login → should redirect to /"
echo "  https://www.asefsondaj.com/admin       → unchanged, works"
