<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบประเมินความพึงพอใจ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 50px; }
        .card { border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 5px solid #0dcaf0; }
        .footer { margin-top: 50px; text-align: center; color: #6c757d; font-size: 0.9em; }
        .rating-group { display: flex; justify-content: space-between; max-width: 300px; margin: 0 auto; }
        .rating-group input[type="radio"] { transform: scale(1.5); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body p-5">
                <h2 class="text-center mb-4">แบบประเมินความพึงพอใจ</h2>
                <p class="text-center text-muted mb-4">กรุณาทำแบบประเมินเพื่อรับ E-Certificate</p>
                
                <?php if (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
                    <div class="alert alert-danger">เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง</div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'exists'): ?>
                    <div class="alert alert-warning">ท่านได้ทำแบบประเมินไปแล้ว <a href="cert.php?email=<?php echo urlencode($_GET['email'] ?? ''); ?>" class="alert-link">คลิกที่นี่เพื่อรับ E-Cert</a></div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'notfound'): ?>
                    <div class="alert alert-danger">ไม่พบประวัติการลงทะเบียนของอีเมลนี้ในระบบ</div>
                <?php endif; ?>

                <form action="feedback_process.php" method="POST">
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">อีเมลที่ใช้ลงทะเบียน</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-4 text-center">
                        <label class="form-label fw-bold d-block mb-3">ความพึงพอใจโดยรวม (1 = น้อยสุด, 5 = มากสุด)</label>
                        <div class="rating-group">
                            <label><input type="radio" name="rating" value="1" required> <br>1</label>
                            <label><input type="radio" name="rating" value="2"> <br>2</label>
                            <label><input type="radio" name="rating" value="3"> <br>3</label>
                            <label><input type="radio" name="rating" value="4"> <br>4</label>
                            <label><input type="radio" name="rating" value="5"> <br>5</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="form-label fw-bold">ข้อเสนอแนะเพิ่มเติม</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-info text-white w-100 py-2">ส่งแบบประเมินและรับ E-Cert</button>
                </form>
            </div>
        </div>
        <div class="footer">
            <?php include 'config.php'; echo FOOTER_CREDIT; ?>
        </div>
    </div>
</body>
</html>
