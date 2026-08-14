<?php
/**
 * Asef Sondaj — Instant Deploy Webhook
 *
 * GitHub pushes a POST here → we verify HMAC signature → run deploy.
 *
 * INSTALLATION:
 *   1. Copy this file to /home/ase3c7ndajcom/bagisto/public/asef-deploy-webhook.php
 *      (Bagisto Document Root, so it's web-accessible at
 *      https://www.asefsondaj.com/asef-deploy-webhook.php)
 *
 *   2. Set your webhook secret in the environment (safest) OR edit the
 *      SECRET constant below.
 *
 *   3. In GitHub → repo Settings → Webhooks → Add webhook:
 *      - Payload URL: https://www.asefsondaj.com/asef-deploy-webhook.php
 *      - Content type: application/json
 *      - Secret: same as SECRET below
 *      - Events: Just the push event
 *
 *   4. Test: push a change → GitHub → Recent Deliveries → should be 200 OK.
 */

// -------- 1) Configuration --------
const SECRET       = 'asef-deploy-2026-token';   // CHANGE THIS AFTER FIRST DEPLOY
const REPO_DIR     = '/home/ase3c7ndajcom/bagisto/packages/AsefSondaj';
const BAGISTO_ROOT = '/home/ase3c7ndajcom/bagisto';
const PHP_BIN      = '/opt/alt/php83/usr/bin/php';
const COMPOSER_BIN = '/home/ase3c7ndajcom/bin/composer';
const LOG_FILE     = '/home/ase3c7ndajcom/asef-deploy.log';

// -------- 2) Helpers --------
function log_line(string $msg): void {
    $stamp = date('Y-m-d H:i:s');
    file_put_contents(LOG_FILE, "[$stamp] $msg\n", FILE_APPEND);
}

function fail(int $code, string $msg): never {
    http_response_code($code);
    log_line("FAIL $code: $msg");
    echo $msg . PHP_EOL;
    exit;
}

// -------- 3) Verify method + signature --------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail(405, 'POST only');
}

$payload   = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

if ($signature === '') {
    fail(401, 'Missing signature');
}

$expected = 'sha256=' . hash_hmac('sha256', $payload, SECRET);

if (! hash_equals($expected, $signature)) {
    fail(401, 'Bad signature');
}

// -------- 4) Verify branch (only main) --------
$data = json_decode($payload, true);
$ref  = $data['ref'] ?? '';

if ($ref !== 'refs/heads/main') {
    http_response_code(200);
    log_line("SKIP: ref=$ref (only main triggers deploy)");
    echo 'skipped non-main branch' . PHP_EOL;
    exit;
}

log_line('==> Deploy triggered from push to main');

// -------- 5) Run deploy --------
// HOME + COMPOSER_HOME must be set explicitly — Apache/nginx-launched PHP
// has no HOME by default and composer fails "The HOME or COMPOSER_HOME env..."
$homeDir = '/home/ase3c7ndajcom';

$cmd = sprintf(
    'export HOME=%s COMPOSER_HOME=%s/.composer PATH=%s/bin:/usr/local/bin:/usr/bin:/bin && cd %s && git pull -q 2>&1 && cd %s && %s dump-autoload -o -q --no-scripts 2>&1 && %s artisan optimize:clear 2>&1 && %s artisan config:cache 2>&1',
    escapeshellarg($homeDir),
    escapeshellarg($homeDir),
    escapeshellarg($homeDir),
    escapeshellarg(REPO_DIR),
    escapeshellarg(BAGISTO_ROOT),
    escapeshellarg(COMPOSER_BIN),
    escapeshellarg(PHP_BIN),
    escapeshellarg(PHP_BIN)
);

exec($cmd . ' 2>&1', $output, $status);

log_line('---- BEGIN OUTPUT ----');
foreach ($output as $line) {
    log_line($line);
}
log_line('---- END OUTPUT (exit ' . $status . ') ----');

if ($status !== 0) {
    fail(500, 'Deploy failed with exit ' . $status);
}

http_response_code(200);
echo 'DEPLOY OK' . PHP_EOL;
log_line('==> Deploy successful');
