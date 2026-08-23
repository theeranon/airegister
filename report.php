<?php
session_start();
require_once 'config.php';

// Simple Login Check
if (isset($_POST['password'])) {
    if ($_POST['password'] === REPORT_PASSWORD) {
        $_SESSION['logged_in'] = true;
    } else {
        $error = "รหัสผ่านไม่ถูกต้อง";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: report.php");
    exit;
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบรายงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#f8f9fa; display:flex; align-items:center; height:100vh; justify-content:center;}</style>
</head>
<body>
    <div class="card p-4 shadow" style="width: 350px;">
        <h4 class="text-center mb-4">รายงานสัมมนา</h4>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <input type="password" name="password" class="form-control mb-3" placeholder="รหัสผ่าน" required>
            <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
        </form>
    </div>
</body>
</html>
<?php
    exit;
}

// Fetch Data for Report
try {
    $sql = "
        SELECT 
            r.id,
            r.name,
            r.email,
            r.phone,
            r.created_at AS registered_at,
            c.checked_in_at,
            f.rating,
            f.comment,
            f.submitted_at AS feedback_submitted_at
        FROM registrations r
        LEFT JOIN checkins c ON r.email = c.email
        LEFT JOIN feedbacks f ON r.email = f.email
        ORDER BY r.created_at DESC
    ";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบรายงานข้อมูลสัมมนา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding: 20px; }
        .card { border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>📊 สรุปข้อมูลผู้เข้าร่วมสัมมนา</h2>
            <a href="?logout=1" class="btn btn-danger">ออกจากระบบ</a>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white p-3">
                    <h5>ลงทะเบียนทั้งหมด</h5>
                    <h3><?php echo count($data); ?> คน</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white p-3">
                    <h5>เช็คอินแล้ว</h5>
                    <h3><?php echo count(array_filter($data, fn($item) => !empty($item['checked_in_at']))); ?> คน</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white p-3">
                    <h5>ประเมินแล้ว</h5>
                    <h3><?php echo count(array_filter($data, fn($item) => !empty($item['feedback_submitted_at']))); ?> คน</h3>
                </div>
            </div>
        </div>

        <div class="card p-4 bg-white">
            <table id="reportTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>อีเมล</th>
                        <th>เบอร์โทร</th>
                        <th>เวลาลงทะเบียน</th>
                        <th>เวลาเช็คอิน</th>
                        <th>คะแนน (1-5)</th>
                        <th>ข้อเสนอแนะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone'] ?? ''); ?></td>
                        <td><?php echo $row['registered_at']; ?></td>
                        <td>
                            <?php if ($row['checked_in_at']): ?>
                                <span class="badge bg-success"><?php echo $row['checked_in_at']; ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary">ยังไม่เช็คอิน</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['rating'] ? $row['rating'] : '-'; ?></td>
                        <td><?php echo htmlspecialchars($row['comment'] ?? '-'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="text-center mt-4 text-muted">
            <small><?php echo FOOTER_CREDIT; ?></small>
        </div>
    </div>

    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- Export Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#reportTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '📥 Export to Excel',
                        className: 'btn btn-success mb-3'
                    }
                ],
                order: [[4, 'desc']], // Sort by registered_at
                language: {
                    search: "ค้นหา:",
                    lengthMenu: "แสดง _MENU_ รายการ",
                    info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: {
                        first: "หน้าแรก",
                        last: "หน้าสุดท้าย",
                        next: "ถัดไป",
                        previous: "ก่อนหน้า"
                    }
                }
            });
        });
    </script>
</body>
</html>
