<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบประเมินความพึงพอใจ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/modern.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">
    <div class="container px-4" style="max-width: 600px;">
        <div class="glass-panel p-5 animate-fade-up">
            <div class="text-center mb-4">
                <span class="fs-1">📝</span>
                <h2 class="fw-bold mt-2">แบบประเมินความพึงพอใจ</h2>
                <p class="text-muted">กรุณาทำแบบประเมินเพื่อรับ E-Certificate ของคุณ</p>
            </div>

            <form action="feedback_process.php" method="POST">
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    <label for="email">อีเมลที่ใช้ลงทะเบียน</label>
                </div>
                
                <div class="mb-4 text-center">
                    <label class="form-label fw-bold d-block mb-2">ความพึงพอใจโดยรวม</label>
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" required/><label for="star5" title="5 stars">★</label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars">★</label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars">★</label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars">★</label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">★</label>
                    </div>
                </div>

                <div class="form-floating mb-5">
                    <textarea class="form-control" id="comment" name="comment" placeholder="ข้อเสนอแนะเพิ่มเติม" style="height: 120px"></textarea>
                    <label for="comment">ข้อเสนอแนะเพิ่มเติม (ถ้ามี)</label>
                </div>

                <button type="submit" class="btn-modern w-100 py-3" style="background: linear-gradient(135deg, #10b981, #059669);">ส่งแบบประเมินและรับ E-Cert</button>
            </form>
            
            <div class="mt-4 text-center text-muted small">
                <?php echo FOOTER_CREDIT; ?>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['status'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($_GET['status'] == 'exists'): ?>
                Swal.fire({
                    icon: 'info',
                    title: 'ท่านประเมินไปแล้ว',
                    text: 'ระบบกำลังพาท่านไปหน้าดาวน์โหลด E-Cert',
                    confirmButtonColor: 'var(--primary-color)',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'cert.php?email=<?php echo urlencode($_GET['email'] ?? ''); ?>';
                });
            <?php elseif ($_GET['status'] == 'notfound'): ?>
                Swal.fire({ icon: 'warning', title: 'ไม่พบข้อมูล', text: 'ไม่พบประวัติการลงทะเบียนของอีเมลนี้', confirmButtonColor: '#f59e0b' });
            <?php elseif ($_GET['status'] == 'error'): ?>
                Swal.fire({ icon: 'error', title: 'ข้อผิดพลาด', text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', confirmButtonColor: '#ef4444' });
            <?php endif; ?>
            <?php if($_GET['status'] !== 'exists'): ?>
            window.history.replaceState({}, document.title, "feedback.php");
            <?php endif; ?>
        });
    </script>
    <?php endif; ?>
</body>
</html>
