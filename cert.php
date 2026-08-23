<?php
require_once 'config.php';

$email = trim($_GET['email'] ?? '');

if (empty($email)) {
    die("ไม่พบอีเมล / Email not provided.");
}

try {
    // Check if feedback exists
    $stmt_fb = $pdo->prepare("SELECT id FROM feedbacks WHERE email = ?");
    $stmt_fb->execute([$email]);
    if ($stmt_fb->rowCount() === 0) {
        die("กรุณาทำแบบประเมินก่อนรับ E-Certificate / Please submit feedback first.");
    }

    // Get name from registration
    $stmt_reg = $pdo->prepare("SELECT name FROM registrations WHERE email = ?");
    $stmt_reg->execute([$email]);
    $user = $stmt_reg->fetch();
    
    if (!$user) {
        die("ไม่พบข้อมูลลงทะเบียน / Registration not found.");
    }
    
    $name = htmlspecialchars($user['name']);

} catch (PDOException $e) {
    die("Database Error");
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>E-Certificate - <?php echo $name; ?></title>
    <style>
        @page { size: A4 landscape; margin: 0; }
        body { 
            margin: 0; 
            padding: 0; 
            font-family: 'Sarabun', sans-serif; 
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .cert-container {
            width: 297mm;
            height: 210mm;
            background: white;
            border: 20px solid #2c3e50;
            box-sizing: border-box;
            position: relative;
            padding: 50px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        .title { font-size: 50px; font-weight: bold; color: #2c3e50; margin-top: 50px; }
        .subtitle { font-size: 24px; color: #7f8c8d; margin-top: 20px; }
        .name { font-size: 60px; font-weight: bold; color: #e74c3c; margin-top: 50px; margin-bottom: 50px; border-bottom: 2px solid #bdc3c7; display: inline-block; padding-bottom: 10px; min-width: 500px; }
        .footer-text { font-size: 20px; color: #34495e; position: absolute; bottom: 80px; width: 100%; left: 0; }
        .brand { position: absolute; bottom: 30px; right: 50px; font-size: 14px; color: #95a5a6; }
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        @media print {
            body { background-color: white; height: auto; display: block; }
            .cert-container { box-shadow: none; border: 20px solid #2c3e50; /* Note: browsers might not print thick borders perfectly */ }
            .print-btn { display: none; }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <button class="print-btn" onclick="window.print()">พิมพ์ / Print PDF</button>

    <div class="cert-container">
        <div class="title">Certificate of Attendance</div>
        <div class="subtitle">This is to certify that</div>
        <div class="name"><?php echo $name; ?></div>
        <div class="subtitle">has successfully participated in the Seminar</div>
        <div class="footer-text">Date: 27 September 2024</div>
        <div class="brand"><?php echo FOOTER_CREDIT; ?></div>
    </div>
</body>
</html>
