<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        header('Location: checkin.php?status=error');
        exit;
    }

    try {
        // Option: Verify if email exists in registrations
        // To make it independent, we can either check or just insert.
        // Doing a check is better so we don't have random emails in checkin table.
        $stmt_check = $pdo->prepare("SELECT id FROM registrations WHERE email = ?");
        $stmt_check->execute([$email]);
        if ($stmt_check->rowCount() === 0) {
            header('Location: checkin.php?status=notfound');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO checkins (email) VALUES (?)");
        $stmt->execute([$email]);
        header('Location: checkin.php?status=success');
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry
            header('Location: checkin.php?status=exists');
        } else {
            header('Location: checkin.php?status=error');
        }
    }
} else {
    header('Location: checkin.php');
}
?>
