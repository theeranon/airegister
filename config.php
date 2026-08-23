<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'seminar_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// LINE OA (Messaging API) configuration
define('LINE_CHANNEL_ACCESS_TOKEN', 'YOUR_CHANNEL_ACCESS_TOKEN_HERE');
define('LINE_TARGET_ID', 'YOUR_GROUP_OR_USER_ID_HERE');

// Report Page Password
define('REPORT_PASSWORD', 'mafia1234');

// Branding
define('FOOTER_CREDIT', 'Aggregate AI by ทีม มาเฟีย AI');

try {
    // Try MySQL first
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Fallback to SQLite for local testing without MySQL
    try {
        $pdo = new PDO("sqlite:" . __DIR__ . "/seminar.sqlite");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e2) {
        die("Database Connection Failed (MySQL & SQLite): " . $e2->getMessage());
    }
}
?>
