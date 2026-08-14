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

# ---------- 1) Ensure PSR-4 autoload entry in root composer.json ----------
echo "==> 1/5 Patching composer.json autoload"
$PHP_BIN -r '
$file = "composer.json";
$data = json_decode(file_get_contents($file), true);
$data["autoload"]["psr-4"] = ["AsefSondaj\\\\AdaptationLayer\\\\" => "packages/AsefSondaj/AdaptationLayer/src/"] + ($data["autoload"]["psr-4"] ?? []);
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
echo "    autoload PSR-4 ensured\n";
'

# ---------- 2) Ensure provider registered in bootstrap/providers.php ----------
echo "==> 2/5 Patching bootstrap/providers.php"
PROVIDERS="bootstrap/providers.php"
if [ ! -f "$PROVIDERS" ]; then
    echo "!! $PROVIDERS not found"
    exit 1
fi

if grep -q "AdaptationServiceProvider" "$PROVIDERS"; then
    echo "    provider already registered — skipped"
else
    $PHP_BIN -r "
        \$file = 'bootstrap/providers.php';
        \$c = file_get_contents(\$file);
        // add use statement after opening <?php if not present
        if (strpos(\$c, 'AsefSondaj\\\\AdaptationLayer\\\\Providers\\\\AdaptationServiceProvider') === false) {
            \$c = preg_replace('/(<\\?php\\s*)/', \"\$1\\nuse AsefSondaj\\\\AdaptationLayer\\\\Providers\\\\AdaptationServiceProvider;\\n\", \$c, 1);
        }
        // add class to returned array
        \$c = preg_replace('/return\\s*\\[/', \"return [\\n    AdaptationServiceProvider::class,\", \$c, 1);
        file_put_contents(\$file, \$c);
        echo '    provider registered' . PHP_EOL;
    "
fi

# ---------- 3) Composer dump-autoload ----------
echo "==> 3/5 Composer dump-autoload"
$COMPOSER_BIN dump-autoload -o --no-scripts

# ---------- 4) Cache clear ----------
echo "==> 4/5 Cache clear"
$PHP_BIN artisan optimize:clear

# ---------- 5) Config cache ----------
echo "==> 5/5 Config cache"
$PHP_BIN artisan config:cache

echo ""
echo "🎉 Asef Adaptation Layer deployed successfully"
echo ""
echo "Test:"
echo "  https://www.asefsondaj.com/checkout    → should redirect to /"
echo "  https://www.asefsondaj.com/customer/login → should redirect to /"
echo "  https://www.asefsondaj.com/admin       → unchanged, works"
