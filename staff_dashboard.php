<?php
session_start();
include 'db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff'){
    header("Location: staff_login.php");
    exit;
}

$staff_dept = $_SESSION['dept']; 
$staff_name = $_SESSION['fullname'];

// Handle the Scheduling Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'set_schedule') {
    $appt_id = intval($_POST['appt_id']);
    $assigned_date = $_POST['appt_date'];
    $assigned_time = $_POST['appt_time'];
    $status = 'Approved';

    $stmt = $conn->prepare("UPDATE appointments SET appointment_date = ?, appointment_time = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssi", $assigned_date, $assigned_time, $status, $appt_id);
    
    if($stmt->execute()){
        header("Location: staff_dashboard.php?view=requests&msg=scheduled");
        exit;
    }
}

// Determine which view to show
// Determine which view to show
$view = $_GET['view'] ?? 'requests';

if ($view == 'all_patients') {
    // Show everything, but join users to get the name
    $query = "SELECT a.*, u.fullname, u.email 
              FROM appointments a 
              LEFT JOIN users u ON a.user_id = u.id 
              ORDER BY a.appointment_date DESC";
    $list_stmt = $conn->prepare($query);
} else {
    // Default: Show ONLY Pending. 
    // IMPORTANT: Your DB shows 'Approved', so they won't show here!
    $query = "SELECT a.*, u.fullname 
              FROM appointments a 
              LEFT JOIN users u ON a.user_id = u.id 
              WHERE a.status = 'Pending'
              ORDER BY a.id ASC";
    $list_stmt = $conn->prepare($query);
}

$list_stmt->execute();
$result = $list_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Portal | VGDH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        :root { 
            --primary: #0d9488; 
            --primary-dark: #0f766e; 
            --mint: #ccfbf1; 
            --cream: #f0fdfa; 
            --sidebar-bg: #134e4a;
            --sidebar-width: 280px; 
        }
        
        body { 
            font-family: 'DM Sans', sans-serif; 
            background-color: var(--cream); 
            color: #1f2937;
            overflow-x: hidden; 
        }

        h1, h2, h3, .serif { font-family: 'DM Serif Display', serif; }
        
        /* Sidebar Styling */
        .sidebar { 
            width: var(--sidebar-width); 
            height: 100vh; 
            position: fixed; 
            background: var(--sidebar-bg); 
            color: white; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            z-index: 1050; 
        }
        .sidebar-header { padding: 40px 25px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .nav-link { 
            color: #99f6e4; 
            padding: 16px 28px; 
            display: flex; 
            align-items: center; 
            transition: 0.2s; 
            text-decoration: none; 
            border-left: 4px solid transparent; 
            font-weight: 500;
        }
        .nav-link:hover { color: white; background: rgba(255,255,255,0.05); }
        .nav-link.active { 
            color: white; 
            background: rgba(255,255,255,0.1); 
            border-left-color: var(--mint); 
        }
        
        /* Main Content */
        .main-content { margin-left: var(--sidebar-width); padding: 40px; min-height: 100vh; transition: 0.3s; }
        .card-custom { 
            background: white; 
            border-radius: 24px; 
            border: 1px solid #e5e7eb; 
            box-shadow: 0 10px 30px rgba(13, 148, 136, 0.03); 
            padding: 30px; 
        }

        .badge-dept { background: var(--mint); color: var(--primary-dark); font-weight: 600; }
        .btn-primary { background: var(--primary); border: none; padding: 10px 20px; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        
        @media (max-width: 991.98px) {
            .sidebar { left: calc(-1 * var(--sidebar-width)); }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; padding: 20px; }
        }

        /* Fluid Typography */
        h2 { font-size: clamp(1.5rem, 4vw, 2.25rem); }
    </style>
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3 class="fw-bold text-white mb-0 serif"><i class="bi bi-heart-pulse-fill me-2"></i>VGDH</h3>
        <p class="small text-uppercase opacity-60 mb-0 tracking-wider" style="letter-spacing: 1px;"><?= htmlspecialchars($staff_dept) ?> Department</p>
    </div>
    <nav class="mt-4">
        <a href="?view=requests" class="nav-link <?= ($view == 'requests') ? 'active' : '' ?>">
            <i class="bi bi-calendar2-check me-3 fs-5"></i> Pending Requests
        </a>
        <a href="?view=all_patients" class="nav-link <?= ($view == 'all_patients') ? 'active' : '' ?>">
            <i class="bi bi-person-lines-fill me-3 fs-5"></i> Patient Master List
        </a>
        <div class="mt-auto px-4 pt-5">
            <a href="logout.php" class="nav-link text-danger mt-5"><i class="bi bi-box-arrow-left me-3"></i> Sign Out</a>
        </div>
    </nav>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1 serif">
                <?= ($view == 'all_patients') ? 'Master Records' : 'Appointment Queue' ?>
            </h2>
            <p class="text-muted mb-0">Welcome back, <strong><?= htmlspecialchars($staff_name) ?></strong></p>
        </div>
        <button class="btn btn-dark d-lg-none rounded-circle p-3" onclick="document.getElementById('sidebar').classList.toggle('active')">
            <i class="bi bi-list fs-4"></i>
        </button>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 py-3 bg-white">
            <i class="bi bi-check-circle-fill text-primary me-2"></i> Schedule updated and patient notified.
        </div>
    <?php endif; ?>

    <div class="card-custom">
        <div class="table-responsive">
            <table class="table align-middle table-borderless">
                <thead>
                    <tr class="text-muted small text-uppercase">
                        <th class="pb-3 ps-0">Patient Info</th>
                        <th class="pb-3">Details</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-end pe-0">Action</th>
                    </tr>
                </thead>
                <tbody class="border-top">
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="border-bottom">
                            <td class="py-4 ps-0">
                                <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($row['fullname']) ?></div>
                                <div class="small text-muted">User Ref: #<?= $row['user_id'] ?></div>
                            </td>
                            <td class="py-4">
                                <?php if($view == 'all_patients'): ?>
                                    <?php if($row['appointment_date']): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar-check me-2 text-primary"></i>
                                            <span><?= date('M d, Y', strtotime($row['appointment_date'])) ?></span>
                                        </div>
                                        <div class="small text-muted ms-4"><?= date('h:i A', strtotime($row['appointment_time'])) ?></div>
                                    <?php else: ?>
                                        <span class="text-muted italic small">Awaiting Schedule</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-dark small"><?= htmlspecialchars($row['reason'] ?? 'Not Specified') ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4">
                                <?php 
                                    $s = $row['status'];
                                    $class = ($s == 'Approved') ? 'bg-success' : (($s == 'Rejected') ? 'bg-danger' : 'badge-dept');
                                ?>
                                <span class="badge <?= $class ?> rounded-pill px-3 py-2"><?= $s ?></span>
                            </td>
                            <td class="py-4 text-end pe-0">
                                <?php if($row['status'] == 'Pending'): ?>
                                    <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" 
                                            onclick="openScheduleModal(<?= $row['id'] ?>, '<?= addslashes($row['fullname']) ?>')">
                                        Assign Date
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-light btn-sm rounded-pill px-3 text-muted border" disabled>Confirmed</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-inbox text-muted display-4 d-block mb-3"></i>
                                <p class="text-muted">No records found for <?= htmlspecialchars($staff_dept) ?>.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-5">
            <div class="modal-header border-0 p-4 pb-0">
                <h4 class="fw-bold serif mb-0">Finalize Appointment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="action" value="set_schedule">
                    <input type="hidden" name="appt_id" id="modal_appt_id">
                    
                    <div class="mb-4 p-3 rounded-4" style="background: var(--cream);">
                        <label class="small text-muted d-block text-uppercase fw-bold mb-1">Confirming for</label>
                        <span id="modal_patient_name" class="fw-bold text-primary-dark fs-5"></span>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Date</label>
                            <input type="date" name="appt_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Time</label>
                            <input type="time" name="appt_time" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">Confirm & Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openScheduleModal(id, name) {
        document.getElementById('modal_appt_id').value = id;
        document.getElementById('modal_patient_name').innerText = name;
        new bootstrap.Modal(document.getElementById('scheduleModal')).show();
    }
</script>
</body>
</html>