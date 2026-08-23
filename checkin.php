<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เช็คอินหน้างาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/modern.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=2012&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(5px); z-index: -1; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="overlay"></div>
    
    <div class="container px-4" style="max-width: 500px;">
        <div class="glass-panel p-5 animate-fade-up text-center">
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="var(--primary-color)" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                  <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 15a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 1 0V14h2.5a.5.5 0 0 1 0 1h-3zm15 0a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 1 0z"/>
                  <path d="M3 3h10v10H3z"/>
                </svg>
            </div>
            
            <h2 class="fw-bold mb-3">เช็คอินเข้างาน</h2>
            <p class="text-muted mb-4">กรุณากรอกอีเมลที่ใช้ลงทะเบียน<br>เพื่อยืนยันสิทธิ์การเข้าร่วมงาน</p>

            <form action="checkin_process.php" method="POST">
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" required>
                    <label for="email">อีเมลของคุณ</label>
                </div>
                <button type="submit" class="btn-modern w-100 py-3" style="font-size: 1.1rem;">ยืนยันการเช็คอิน</button>
            </form>
            
            <div class="mt-5 text-muted small">
                <?php echo FOOTER_CREDIT; ?>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['status'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($_GET['status'] == 'success'): ?>
                Swal.fire({ icon: 'success', title: 'เช็คอินสำเร็จ!', text: 'ยินดีต้อนรับเข้าสู่งานครับ', confirmButtonColor: '#10b981' });
            <?php elseif ($_GET['status'] == 'exists'): ?>
                Swal.fire({ icon: 'info', title: 'แจ้งเตือน', text: 'ท่านได้ทำการเช็คอินไปแล้ว', confirmButtonColor: 'var(--primary-color)' });
            <?php elseif ($_GET['status'] == 'notfound'): ?>
                Swal.fire({ icon: 'warning', title: 'ไม่พบข้อมูล', text: 'ไม่พบอีเมลนี้ในระบบลงทะเบียน กรุณาติดต่อสต๊าฟ', confirmButtonColor: '#f59e0b' });
            <?php elseif ($_GET['status'] == 'error'): ?>
                Swal.fire({ icon: 'error', title: 'ข้อผิดพลาด', text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', confirmButtonColor: '#ef4444' });
            <?php endif; ?>
            window.history.replaceState({}, document.title, "checkin.php");
        });
    </script>
    <?php endif; ?>
</body>
</html>
