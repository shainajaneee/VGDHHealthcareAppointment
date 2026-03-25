<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: admin_login.php");
    exit;
}

if(isset($_GET['action']) && isset($_GET['id'])){
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    if($action == 'approve'){
        $conn->query("UPDATE appointments SET status='Approved' WHERE id=$id");
    } elseif($action == 'reject'){
        $conn->query("UPDATE appointments SET status='Rejected' WHERE id=$id");
    }
    header("Location: admin.php");
    exit;
}

// Stats for the dashboard
$total_res = $conn->query("SELECT COUNT(*) as count FROM appointments");
$total_count = $total_res->fetch_assoc()['count'];

$pending_res = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status='Pending'");
$pending_count = $pending_res->fetch_assoc()['count'];

$result = $conn->query("SELECT * FROM appointments ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VGDH Admin | Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #212529; color: white; width: 250px; position: fixed; }
        .main-content { margin-left: 250px; padding: 30px; }
        .nav-link { color: rgba(255,255,255,0.7); border-radius: 8px; margin: 5px 15px; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; }
        .stat-card { border: none; border-radius: 15px; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        .table-card { border: none; border-radius: 15px; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
        .status-badge { padding: 0.5em 1em; border-radius: 50px; font-weight: 500; font-size: 0.75rem; }
        .action-btn { border-radius: 8px; }
    </style>
</head>
<body>

<div class="sidebar d-none d-md-block shadow">
    <div class="p-4 mb-4">
        <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-heart-pulse-fill me-2"></i>VGDH Admin</h4>
    </div>
    <nav class="nav flex-column mt-3">
        <a class="nav-link active" href="#"><i class="bi bi-grid-1x2-fill me-2"></i> Dashboard</a>
        <a class="nav-link" href="#"><i class="bi bi-calendar-event me-2"></i> Appointments</a>
        <a class="nav-link" href="#"><i class="bi bi-people me-2"></i> Patients</a>
        <div class="mt-auto p-3">
            <a class="btn btn-outline-danger btn-sm w-100" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
        </div>
    </nav>
</div>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Management Overview</h2>
                <p class="text-muted">Review and process hospital appointments.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white shadow-sm border"><i class="bi bi-download me-2"></i>Export</button>
                <button class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-2"></i>New Appointment</button>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card stat-card bg-white p-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 me-3"><i class="bi bi-calendar-check fs-4"></i></div>
                        <div><p class="text-muted mb-0 small uppercase fw-bold">Total Requests</p><h4 class="mb-0 fw-bold"><?= $total_count ?></h4></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card bg-white p-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3 me-3"><i class="bi bi-clock-history fs-4"></i></div>
                        <div><p class="text-muted mb-0 small uppercase fw-bold">Pending Approval</p><h4 class="mb-0 fw-bold"><?= $pending_count ?></h4></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-dark">Recent Appointment Requests</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Patient ID</th>
                            <th>Department & Doctor</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="ps-4 fw-medium text-primary">#<?= $row['user_id'] ?></td>
                                    <td>
                                        <div class="fw-bold"><?= $row['department'] ?></div>
                                        <div class="text-muted small">Dr. <?= $row['doctor'] ?></div>
                                    </td>
                                    <td>
                                        <div><?= date("M d, Y", strtotime($row['appointment_date'])) ?></div>
                                        <div class="text-muted small"><?= $row['appointment_time'] ?></div>
                                    </td>
                                    <td>
                                        <?php 
                                            $badgeClass = ($row['status']=='Approved' ? 'bg-success' : ($row['status']=='Rejected' ? 'bg-danger' : 'bg-warning text-dark'));
                                        ?>
                                        <span class="status-badge <?= $badgeClass ?>"><?= $row['status'] ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <?php if($row['status'] == 'Pending'): ?>
                                            <a href="?action=approve&id=<?= $row['id'] ?>" class="btn btn-outline-success btn-sm action-btn me-1">Approve</a>
                                            <a href="?action=reject&id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm action-btn">Reject</a>
                                        <?php else: ?>
                                            <button class="btn btn-light btn-sm action-btn" disabled>Processed</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-5">No appointments found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>