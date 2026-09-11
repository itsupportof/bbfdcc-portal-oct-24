<?php
/**
 * Database configuration.
 *
 * Credentials are NOT stored in this (version-controlled) file. They are loaded
 * from either:
 *   1. config.local.php  (a file that is git-ignored — see config.local.php.example), or
 *   2. environment variables  (DB_HOST, DB_NAME, DB_USER, DB_PASS).
 *
 * Copy config.local.php.example to config.local.php and fill in real values,
 * then upload config.local.php to the server once.
 */

$__local = __DIR__ . '/config.local.php';
if (is_file($__local)) {
    require $__local;
}

$dbHost = getenv('DB_HOST') ?: (isset($DB_HOST) ? $DB_HOST : 'localhost');
$dbName = getenv('DB_NAME') ?: (isset($DB_NAME) ? $DB_NAME : '');
$dbUser = getenv('DB_USER') ?: (isset($DB_USER) ? $DB_USER : '');
$dbPass = getenv('DB_PASS') ?: (isset($DB_PASS) ? $DB_PASS : '');

if ($dbName === '' || $dbUser === '') {
    error_log('config.php: database credentials are not configured (missing config.local.php or DB_* env vars).');
    die('Database configuration is missing. Please contact the administrator.');
}

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    // Log the detail server-side; never expose connection details to the browser.
    error_log('DB connection failed: ' . $e->getMessage());
    die('Database connection error. Please try again later.');
}

/*** Base URL ***/
$url = "https://www.brightbeginningsfdcc.com.au/portal/";
?>
