<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียนเข้าร่วมสัมมนา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/modern.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="split-layout">
        <!-- Left Side: Image -->
        <div class="split-left" style="background-image: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2070&auto=format&fit=crop');">
            <div class="overlay"></div>
            <div class="position-relative z-1 h-100 d-flex flex-column justify-content-center p-5 text-white animate-fade-up">
                <h1 class="display-4 fw-bold mb-4">Tech Innovation Seminar 2026</h1>
                <p class="lead mb-0" style="opacity: 0.9;">ร่วมเปิดมุมมองใหม่แห่งอนาคตไปพร้อมกัน<br>เตรียมพบกับวิทยากรชั้นนำและเครือข่ายคนไอทีระดับประเทศ</p>
            </div>
        </div>
        
        <!-- Right Side: Form -->
        <div class="split-right">
            <div class="form-wrapper animate-fade-up" style="animation-delay: 0.2s;">
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-3" style="width: 64px; height: 64px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                          <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
                        </svg>
                    </div>
                    <h2 class="fw-bold">ลงทะเบียนเข้าร่วมงาน</h2>
                    <p class="text-muted">กรอกข้อมูลเพื่อสำรองที่นั่งของคุณ</p>
                </div>

                <form action="register_process.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อ - นามสกุล" required>
                        <label for="name">ชื่อ - นามสกุล</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                        <label for="email">อีเมล (สำหรับใช้อ้างอิงและรับ E-Cert)</label>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="เบอร์โทรศัพท์">
                        <label for="phone">เบอร์โทรศัพท์ (ไม่บังคับ)</label>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted mb-3 d-block">รูปแบบการเข้าร่วมงาน</label>
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="attendance_type" id="onsite" value="Onsite" checked>
                                <label class="btn btn-outline-primary w-100 py-3 rounded-4" for="onsite">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo-alt-fill mb-2 d-block mx-auto" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
                                    Onsite (หน้างาน)
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="attendance_type" id="virtual" value="Virtual">
                                <label class="btn btn-outline-info w-100 py-3 rounded-4" for="virtual">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-laptop mb-2 d-block mx-auto" viewBox="0 0 16 16"><path d="M13.5 3a.5.5 0 0 1 .5.5V11H2V3.5a.5.5 0 0 1 .5-.5zm-11-1A1.5 1.5 0 0 0 1 3.5V12h14V3.5A1.5 1.5 0 0 0 13.5 2zM0 12.5h16a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5"/></svg>
                                    Virtual (ออนไลน์)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-modern w-100 mb-4">ยืนยันการลงทะเบียน</button>
                </form>
                
                <div class="text-center">
                    <small class="text-muted"><?php echo FOOTER_CREDIT; ?></small>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['status'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($_GET['status'] == 'success'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'ลงทะเบียนสำเร็จ ขอบคุณที่ให้ความสนใจครับ',
                    confirmButtonColor: 'var(--primary-color)'
                });
            <?php elseif ($_GET['status'] == 'exists'): ?>
                Swal.fire({
                    icon: 'info',
                    title: 'แจ้งเตือน',
                    text: 'อีเมลนี้ได้ทำการลงทะเบียนไว้แล้ว',
                    confirmButtonColor: 'var(--primary-color)'
                });
            <?php elseif ($_GET['status'] == 'error'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'ข้อผิดพลาด',
                    text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: 'var(--primary-color)'
                });
            <?php endif; ?>
            // Clean URL
            window.history.replaceState({}, document.title, "index.php");
        });
    </script>
    <?php endif; ?>
</body>
</html>
