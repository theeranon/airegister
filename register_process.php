<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $attendance_type = trim($_POST['attendance_type'] ?? 'Onsite');

    if (empty($name) || empty($email)) {
        header('Location: index.php?status=error');
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO registrations (name, email, phone, attendance_type) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $attendance_type]);
        header('Location: index.php?status=success');
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            header('Location: index.php?status=exists');
        } else {
            header('Location: index.php?status=error');
        }
    }
} else {
    header('Location: index.php');
}
?>
