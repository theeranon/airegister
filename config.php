<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'seminar_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// LINE OA (Messaging API) configuration
define('LINE_CHANNEL_ACCESS_TOKEN', 'YOUR_CHANNEL_ACCESS_TOKEN_HERE');
define('LINE_TARGET_ID', 'YOUR_GROUP_OR_USER_ID_HERE'); // The ID of the group or user to send the push message to

// Report Page Password
define('REPORT_PASSWORD', 'mafia1234'); // รหัสผ่านสำหรับเข้าดูหน้ารีพอร์ต

// Branding
define('FOOTER_CREDIT', 'Aggregate AI by ทีม มาเฟีย AI');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>
