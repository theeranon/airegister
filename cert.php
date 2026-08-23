<?php
require_once 'config.php';

$email = trim($_GET['email'] ?? '');

if (empty($email)) {
    die("ไม่พบอีเมล / Email not provided.");
}

try {
    $stmt_fb = $pdo->prepare("SELECT id FROM feedbacks WHERE email = ?");
    $stmt_fb->execute([$email]);
    if ($stmt_fb->rowCount() === 0) {
        die("กรุณาทำแบบประเมินก่อนรับ E-Certificate / Please submit feedback first.");
    }

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
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Prompt:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            margin: 0; padding: 20px; 
            background: #cbd5e1; 
            display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh;
            font-family: 'Prompt', sans-serif;
        }
        
        .print-btn {
            background: #2563eb; color: white; border: none; padding: 12px 24px; border-radius: 8px;
            font-size: 16px; cursor: pointer; font-weight: 600; font-family: 'Prompt', sans-serif;
            margin-bottom: 20px; box-shadow: 0 4px 6px rgba(37,99,235,0.2); transition: 0.3s;
        }
        .print-btn:hover { background: #1d4ed8; transform: translateY(-2px); }

        .cert-container {
            width: 297mm; height: 210mm; /* A4 Landscape */
            background-color: white;
            background-image: radial-gradient(#f8fafc 10%, transparent 10%), radial-gradient(#f8fafc 10%, transparent 10%);
            background-position: 0 0, 10px 10px; background-size: 20px 20px;
            position: relative;
            box-sizing: border-box; padding: 40px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }

        .cert-border {
            position: absolute; inset: 20px; border: 2px solid #94a3b8; outline: 8px solid #cbd5e1; outline-offset: -12px;
            display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px; text-align: center;
            background: rgba(255,255,255,0.9); z-index: 1;
        }

        .logo-placeholder { width: 80px; height: 80px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 30px; }
        .logo-placeholder svg { width: 40px; height: 40px; fill: #64748b; }

        .title { font-family: 'Cinzel', serif; font-size: 56px; font-weight: 700; color: #0f172a; margin: 0; letter-spacing: 2px; }
        .subtitle { font-size: 22px; color: #64748b; margin: 20px 0 40px 0; font-weight: 400; }
        
        .name { 
            font-family: 'Prompt', sans-serif; font-size: 52px; font-weight: 600; color: #1e293b; 
            border-bottom: 2px solid #cbd5e1; padding-bottom: 10px; margin-bottom: 30px;
            min-width: 60%; text-align: center;
        }
        
        .description { font-size: 20px; color: #475569; max-width: 70%; line-height: 1.6; }
        
        .signatures {
            display: flex; justify-content: space-between; width: 60%; margin-top: 60px;
        }
        .sign-block { text-align: center; }
        .sign-line { width: 200px; border-bottom: 1px solid #94a3b8; margin-bottom: 10px; height: 40px; }
        .sign-name { font-size: 16px; color: #0f172a; font-weight: 600; }
        .sign-title { font-size: 14px; color: #64748b; }

        .date { position: absolute; bottom: 50px; left: 50px; font-size: 16px; color: #475569; font-weight: 600; }
        .brand { position: absolute; bottom: 50px; right: 50px; font-size: 14px; color: #94a3b8; letter-spacing: 1px; }

        @media print {
            body { background: none; padding: 0; display: block; }
            .print-btn { display: none; }
            .cert-container { box-shadow: none; margin: 0; width: 100%; height: 100%; page-break-after: avoid; }
            @page { size: A4 landscape; margin: 0; }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right:8px; vertical-align:-2px;">
          <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
          <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
        </svg>
        พิมพ์ E-Certificate (Save as PDF)
    </button>

    <div class="cert-container">
        <div class="cert-border">
            <div class="logo-placeholder">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            
            <h1 class="title">CERTIFICATE OF ATTENDANCE</h1>
            <div class="subtitle">This certificate is proudly presented to</div>
            
            <div class="name"><?php echo $name; ?></div>
            
            <div class="description">
                For successful participation and contribution to the<br>
                <strong>Tech Innovation Seminar 2026</strong>
            </div>
            
            <div class="signatures">
                <div class="sign-block">
                    <div class="sign-line"></div>
                    <div class="sign-name">John Doe</div>
                    <div class="sign-title">Event Organizer</div>
                </div>
                <div class="sign-block">
                    <div class="sign-line"></div>
                    <div class="sign-name">Jane Smith</div>
                    <div class="sign-title">Keynote Speaker</div>
                </div>
            </div>

            <div class="date">Date: 27 September 2026</div>
            <div class="brand"><?php echo FOOTER_CREDIT; ?></div>
        </div>
    </div>
</body>
</html>
