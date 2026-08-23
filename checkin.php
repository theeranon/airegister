<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เช็คอินเข้าร่วมงานสัมมนา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 500px; margin-top: 50px; }
        .card { border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 5px solid #198754; }
        .footer { margin-top: 50px; text-align: center; color: #6c757d; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body p-5 text-center">
                <h2 class="mb-4">เช็คอินหน้างาน</h2>
                <p class="text-muted mb-4">กรุณากรอกอีเมลที่ท่านใช้ลงทะเบียนเพื่อยืนยันการเข้าร่วมงาน</p>
                
                <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success">เช็คอินสำเร็จ! ยินดีต้อนรับเข้าสู่งานครับ</div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'exists'): ?>
                    <div class="alert alert-warning">ท่านได้ทำการเช็คอินไปแล้ว</div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'notfound'): ?>
                    <div class="alert alert-danger">ไม่พบอีเมลนี้ในระบบลงทะเบียน กรุณาติดต่อสต๊าฟ</div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
                    <div class="alert alert-danger">เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง</div>
                <?php endif; ?>

                <form action="checkin_process.php" method="POST">
                    <div class="mb-4">
                        <input type="email" class="form-control form-control-lg text-center" id="email" name="email" placeholder="email@example.com" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">ยืนยันการเช็คอิน</button>
                </form>
            </div>
        </div>
        <div class="footer">
            <?php include 'config.php'; echo FOOTER_CREDIT; ?>
        </div>
    </div>
</body>
</html>
