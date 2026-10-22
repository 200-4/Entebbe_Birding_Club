<?php
declare(strict_types=1);

function app_config(): array
{
  static $config;
  if ($config !== null) return $config;
  $path = __DIR__ . '/config.php';
  if (!is_file($path)) throw new RuntimeException('Missing private/config.php. Follow the cPanel setup instructions.');
  $config = require $path;
  if (!is_array($config) || empty($config['db']['name']) || empty($config['db']['user']) ||
      ($config['db']['password'] ?? '') === 'REPLACE_WITH_DATABASE_PASSWORD') {
    throw new RuntimeException('Database settings are incomplete.');
  }
  return $config;
}

function db(): PDO
{
  static $pdo;
  if ($pdo instanceof PDO) return $pdo;
  $s = app_config()['db'];
  $dsn = 'pgsql:host=' . ($s['host'] ?? 'localhost') . ';port=' . ($s['port'] ?? '5432') . ';dbname=' . $s['name'];
  $pdo = new PDO($dsn, $s['user'], $s['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ]);
  return $pdo;
}

function e(?string $value): string
{
  return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function is_managed_post_image(string $path): bool
{
  return strncmp($path, 'uploads/posts/', 14) === 0;
}

function start_admin_session(): void
{
  if (session_status() === PHP_SESSION_ACTIVE) return;
  session_name('ebc_admin');
  session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'samesite' => 'Strict',
    'path' => '/',
  ]);
  ini_set('session.use_strict_mode', '1');
  session_start();
}

function csrf_token(): string
{
  start_admin_session();
  if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
  start_admin_session();
  $token = $_POST['csrf_token'] ?? '';
  if (!is_string($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(400);
    exit('Invalid form token. Reload the page and try again.');
  }
}

function require_admin(): void
{
  start_admin_session();
  if (empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
  }
}

function render_db_error(Throwable $error): void
{
  error_log('EBC database error: ' . $error->getMessage());
  http_response_code(503);
  echo '<!doctype html><html lang="en"><meta charset="utf-8"><title>Temporarily unavailable</title>';
  echo '<body style="font:16px system-ui;max-width:680px;margin:12vh auto;padding:24px;color:#16301f">';
  echo '<h1>Posts are temporarily unavailable</h1><p>The PostgreSQL database is not ready or could not be reached. Please check the setup instructions or try again later.</p></body></html>';
  exit;
}
