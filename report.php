<?php
session_start();
require_once 'config.php';

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
    <title>เข้าสู่ระบบรายงาน - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/modern.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1557682250-33bd709cbe85?q=80&w=2029&auto=format&fit=crop');
            background-size: cover; background-position: center;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="glass-panel p-5 animate-fade-up text-center" style="width: 100%; max-width: 400px;">
        <div class="mb-4 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
              <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.084.662 3 3 0 0 1-.597.22h-.034a3 3 0 0 1-.597-.22 7 7 0 0 1-1.084-.662 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
              <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415"/>
            </svg>
            <h3 class="mt-3 fw-bold">Admin Portal</h3>
        </div>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger" style="background: rgba(220,53,69,0.9); border: none; color: white;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน" required>
                <label for="password">รหัสผ่าน</label>
            </div>
            <button type="submit" class="btn-modern w-100 py-2">เข้าสู่ระบบ</button>
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
        SELECT r.id, r.name, r.email, r.phone, r.created_at AS registered_at,
               c.checked_in_at, f.rating, f.comment, f.submitted_at AS feedback_submitted_at
        FROM registrations r
        LEFT JOIN checkins c ON r.email = c.email
        LEFT JOIN feedbacks f ON r.email = f.email
        ORDER BY r.created_at DESC
    ";
    $stmt = $pdo->query($sql);
    $data = $stmt->fetchAll();
    
    $total = count($data);
    $checked_in = count(array_filter($data, fn($item) => !empty($item['checked_in_at'])));
    $feedbacks = count(array_filter($data, fn($item) => !empty($item['feedback_submitted_at'])));
    $avg_rating = $feedbacks > 0 ? round(array_sum(array_column(array_filter($data, fn($item) => !empty($item['rating'])), 'rating')) / $feedbacks, 1) : 0;
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - สรุปข้อมูลสัมมนา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/modern.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background-color: #f1f5f9; }
        .navbar { background: white; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1); }
        .table-glass { background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); padding: 1.5rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg px-4 py-3 mb-4">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold text-primary">⚡ Event Dashboard</span>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small"><?php echo FOOTER_CREDIT; ?></span>
                <a href="?logout=1" class="btn btn-outline-danger btn-sm rounded-pill px-3">ออกจากระบบ</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 pb-5">
        <!-- Stat Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card bg-primary text-white">
                    <div class="stat-title">ลงทะเบียนทั้งหมด</div>
                    <div class="stat-value"><?php echo number_format($total); ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-success text-white">
                    <div class="stat-title">เช็คอินหน้างาน</div>
                    <div class="stat-value"><?php echo number_format($checked_in); ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-info text-white">
                    <div class="stat-title">ผู้ประเมินผล</div>
                    <div class="stat-value"><?php echo number_format($feedbacks); ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-warning text-dark">
                    <div class="stat-title">คะแนนเฉลี่ย</div>
                    <div class="stat-value">⭐ <?php echo $avg_rating; ?></div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-glass animate-fade-up">
            <table id="reportTable" class="table table-hover align-middle" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="rounded-start">ID</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>อีเมล</th>
                        <th>เบอร์โทร</th>
                        <th>ลงทะเบียนเมื่อ</th>
                        <th>เช็คอิน</th>
                        <th>คะแนน</th>
                        <th class="rounded-end">ข้อเสนอแนะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                    <tr>
                        <td class="text-muted">#<?php echo $row['id']; ?></td>
                        <td class="fw-medium"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone'] ?? '-'); ?></td>
                        <td class="small text-muted"><?php echo $row['registered_at']; ?></td>
                        <td>
                            <?php if ($row['checked_in_at']): ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">เช็คอินแล้ว</span>
                            <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3">ยังไม่มา</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['rating']): ?>
                                <span class="text-warning fw-bold">⭐ <?php echo $row['rating']; ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="small"><?php echo htmlspecialchars($row['comment'] ?? '-'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#reportTable').DataTable({
                dom: '<"row mb-3"<"col-md-6"B><"col-md-6"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel me-2" viewBox="0 0 16 16"><path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/></svg> Export to Excel',
                        className: 'btn btn-success rounded-pill px-4'
                    }
                ],
                order: [[4, 'desc']],
                language: {
                    search: "",
                    searchPlaceholder: "🔍 ค้นหารายชื่อ...",
                    lengthMenu: "แสดง _MENU_ รายการ",
                    info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: { first: "หน้าแรก", last: "หน้าสุดท้าย", next: "ถัดไป", previous: "ก่อนหน้า" }
                }
            });
        });
    </script>
</body>
</html>
