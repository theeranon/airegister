<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $rating = intval($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if (empty($email) || $rating < 1 || $rating > 5) {
        header('Location: feedback.php?status=error');
        exit;
    }

    try {
        // Verify email in registrations to ensure they actually registered
        $stmt_check = $pdo->prepare("SELECT id FROM registrations WHERE email = ?");
        $stmt_check->execute([$email]);
        if ($stmt_check->rowCount() === 0) {
            header('Location: feedback.php?status=notfound');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO feedbacks (email, rating, comment) VALUES (?, ?, ?)");
        $stmt->execute([$email, $rating, $comment]);
        
        // Success - redirect to cert
        header('Location: cert.php?email=' . urlencode($email));
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate entry
            header('Location: feedback.php?status=exists&email=' . urlencode($email));
        } else {
            header('Location: feedback.php?status=error');
        }
    }
} else {
    header('Location: feedback.php');
}
?>
