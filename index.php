<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียนเข้าร่วมสัมมนา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 50px; }
        .card { border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .footer { margin-top: 50px; text-align: center; color: #6c757d; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body p-5">
                <h2 class="text-center mb-4">ลงทะเบียนเข้าร่วมสัมมนา</h2>
                
                <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success">ลงทะเบียนสำเร็จ! ขอบคุณที่ให้ความสนใจครับ</div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'exists'): ?>
                    <div class="alert alert-warning">อีเมลนี้ได้ทำการลงทะเบียนไว้แล้ว</div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
                    <div class="alert alert-danger">เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง</div>
                <?php endif; ?>

                <form action="register_process.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อ - นามสกุล</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">อีเมล (สำหรับใช้อ้างอิงและรับ E-Cert)</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="form-label">เบอร์โทรศัพท์ (ไม่บังคับ)</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">ยืนยันการลงทะเบียน</button>
                </form>
            </div>
        </div>
        <div class="footer">
            <?php include 'config.php'; echo FOOTER_CREDIT; ?>
        </div>
    </div>
</body>
</html>
