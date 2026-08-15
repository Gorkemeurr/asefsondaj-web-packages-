#!/bin/bash
# Asef Sondaj — Adaptation Layer + Theme install script
# Idempotent: safe to run multiple times

set -e

BAGISTO_ROOT="${BAGISTO_ROOT:-$HOME/bagisto}"
PHP_BIN="${PHP_BIN:-/opt/alt/php83/usr/bin/php}"
COMPOSER_BIN="${COMPOSER_BIN:-$HOME/bin/composer}"

echo "==> Asef Sondaj Deployment"
echo "    Bagisto root: $BAGISTO_ROOT"
echo "    PHP:          $PHP_BIN"
echo "    Composer:     $COMPOSER_BIN"

if [ ! -d "$BAGISTO_ROOT" ]; then
    echo "!! Bagisto not found at $BAGISTO_ROOT"
    exit 1
fi

cd "$BAGISTO_ROOT"

# ---------- 1) Require both packages in root composer.json ----------
echo "==> 1/9 Patching composer.json require (both packages)"
$PHP_BIN -r '
$file = "composer.json";
$data = json_decode(file_get_contents($file), true);

// Cleanup any accidental duplicate PSR-4 entries from earlier attempts
foreach (["AsefSondaj\\\\AdaptationLayer\\\\", "AsefSondaj\\\\Theme\\\\"] as $ns) {
    if (isset($data["autoload"]["psr-4"][$ns])) unset($data["autoload"]["psr-4"][$ns]);
}

$data["require"]["asefsondaj/adaptation-layer"] = "@dev";
$data["require"]["asefsondaj/theme"]            = "@dev";

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
echo "    require asefsondaj/adaptation-layer + asefsondaj/theme ensured\n";
'

# ---------- 2) Ensure both providers registered in bootstrap/providers.php ----------
echo "==> 2/9 Patching bootstrap/providers.php"
PROVIDERS="bootstrap/providers.php"
if [ ! -f "$PROVIDERS" ]; then
    echo "!! $PROVIDERS not found"
    exit 1
fi

$PHP_BIN -r "
    \$file = 'bootstrap/providers.php';
    \$c = file_get_contents(\$file);
    \$providers = [
        'AsefSondaj\\\\AdaptationLayer\\\\Providers\\\\AdaptationServiceProvider' => 'AdaptationServiceProvider',
        'AsefSondaj\\\\Theme\\\\Providers\\\\AsefThemeServiceProvider'             => 'AsefThemeServiceProvider',
    ];
    foreach (\$providers as \$fqn => \$short) {
        if (strpos(\$c, \$short) !== false) continue;
        // add use statement after opening <?php if not present
        if (strpos(\$c, \$fqn) === false) {
            \$c = preg_replace('/(<\\?php\\s*)/', \"\$1\\nuse \$fqn;\\n\", \$c, 1);
        }
        // add class to returned array
        \$c = preg_replace('/return\\s*\\[/', \"return [\\n    \$short::class,\", \$c, 1);
    }
    file_put_contents(\$file, \$c);
    echo '    providers registered' . PHP_EOL;
"

# ---------- 3) Composer install/update ----------
echo "==> 3/9 Composer update + dump-autoload"
$COMPOSER_BIN update asefsondaj/adaptation-layer asefsondaj/theme --no-scripts --no-interaction 2>&1 || true
$COMPOSER_BIN require asefsondaj/adaptation-layer:@dev asefsondaj/theme:@dev --no-scripts --no-interaction 2>&1 || true
$COMPOSER_BIN dump-autoload -o --no-scripts

# ---------- 4) Cache clear ----------
echo "==> 4/9 Cache clear"
$PHP_BIN artisan optimize:clear

# ---------- 5) Publish AdaptationLayer assets (logo/favicon fallback + webhook self-update) ----------
echo "==> 5/9 Publishing AdaptationLayer assets + webhook"
ADP_ASSETS="$PWD/packages/AsefSondaj/AdaptationLayer/src/Resources/assets"
if [ -f "$ADP_ASSETS/images/logo.png" ]; then
    cp -f "$ADP_ASSETS/images/logo.png" "$BAGISTO_ROOT/public/asef-logo.png"
    echo "    asef-logo.png -> public/"
fi
if [ -f "$ADP_ASSETS/images/favicon.ico" ]; then
    cp -f "$ADP_ASSETS/images/favicon.ico" "$BAGISTO_ROOT/public/favicon.ico"
fi

# Self-update webhook.php
WEBHOOK_SRC="$PWD/packages/AsefSondaj/deploy-webhook.php"
WEBHOOK_DST="$BAGISTO_ROOT/public/asef-deploy-webhook.php"
if [ -f "$WEBHOOK_SRC" ]; then
    if [ -f "$WEBHOOK_DST" ]; then
        CURRENT_SECRET=$(grep -oP "SECRET\s*=\s*'\K[^']+" "$WEBHOOK_DST" | head -1)
        cp -f "$WEBHOOK_SRC" "$WEBHOOK_DST"
        if [ -n "$CURRENT_SECRET" ] && [ "$CURRENT_SECRET" != "asef-deploy-2026-token" ]; then
            sed -i "s|asef-deploy-2026-token|$CURRENT_SECRET|" "$WEBHOOK_DST"
        fi
        echo "    webhook self-updated"
    else
        cp -f "$WEBHOOK_SRC" "$WEBHOOK_DST"
        echo "    webhook installed (default token — CHANGE IT)"
    fi
fi

# ---------- 6) Publish Theme assets to public/asef-theme/ ----------
echo "==> 6/9 Publishing Theme assets"
THEME_ASSETS_SRC="$PWD/packages/AsefSondaj/Theme/src/Resources/assets"
THEME_ASSETS_DST="$BAGISTO_ROOT/public/asef-theme"
if [ -d "$THEME_ASSETS_SRC" ]; then
    mkdir -p "$THEME_ASSETS_DST"
    cp -rf "$THEME_ASSETS_SRC/"* "$THEME_ASSETS_DST/"
    echo "    theme assets -> public/asef-theme/"
    echo "    $(find $THEME_ASSETS_DST -type f | wc -l) files published"
fi

# ---------- 7) Inject fallback CSS in Bagisto core_config (belt+braces for e-commerce hides) ----------
echo "==> 7/9 Injecting fallback storefront CSS via core_config"
CSS_FILE="$ADP_ASSETS/css/asef-storefront.css"
if [ -f "$CSS_FILE" ]; then
    $PHP_BIN "$BAGISTO_ROOT/artisan" tinker --execute "
        \$css = file_get_contents('$CSS_FILE');
        \$now = now();
        \$exists = DB::table('core_config')->where('code', 'general.content.custom_scripts.custom_css')->first();
        if (\$exists) {
            DB::table('core_config')->where('code', 'general.content.custom_scripts.custom_css')->update(['value' => \$css, 'updated_at' => \$now]);
        } else {
            DB::table('core_config')->insert([
                'code' => 'general.content.custom_scripts.custom_css',
                'value' => \$css,
                'channel_code' => null,
                'locale_code' => null,
                'created_at' => \$now,
                'updated_at' => \$now,
            ]);
        }
        echo 'Custom CSS injected (' . strlen(\$css) . ' bytes)';
    " 2>&1 || echo "    (config injection skipped)"
fi

# ---------- 8) Run Asef catalog seeder (idempotent) ----------
echo "==> 8/9 Seeding Asef catalog (products + categories)"
$PHP_BIN "$BAGISTO_ROOT/artisan" db:seed --class="AsefSondaj\\Theme\\Database\\Seeders\\AsefCatalogSeeder" --force 2>&1 || echo "    (seeder skipped — will retry next deploy)"

# ---------- 9) Config cache ----------
echo "==> 9/9 Config cache"
$PHP_BIN artisan config:cache

echo ""
echo "🎉 Asef Sondaj (Adaptation + Theme) deployed"
echo ""
echo "Test:"
echo "  https://www.asefsondaj.com/            → Asef home (hero + kategoriler + featured)"
echo "  https://www.asefsondaj.com/katalog     → Katalog listesi"
echo "  https://www.asefsondaj.com/teklif      → Teklif Listem"
echo "  https://www.asefsondaj.com/iletisim    → İletişim"
echo "  https://www.asefsondaj.com/checkout    → redirect to /"
echo "  https://www.asefsondaj.com/admin       → admin panel (unchanged)"
