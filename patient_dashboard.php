<?php
session_start();
include 'db.php';

// Check if logged in as patient
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient'){
    header("Location: patient_register.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'];

// Handle booking request
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    $stmt = $conn->prepare("INSERT INTO appointments (user_id, department, reason, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->bind_param("iss", $user_id, $department, $reason);
    
    if($stmt->execute()){
        header("Location: patient_dashboard.php?status=success");
        exit;
    }
}

// Get patient's appointments
$result = $conn->query("SELECT * FROM appointments WHERE user_id = $user_id ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal | VGDH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --primary: #0d9488; 
            --primary-dark: #0f766e; 
            --mint: #ccfbf1; 
            --cream: #f0fdfa; 
            --text-dark: #134e4a;
        }

        body { 
            font-family: 'DM Sans', sans-serif; 
            background-color: var(--cream); 
            color: #1f2937; 
        }

        h1, h2, h4, .serif { font-family: 'DM Serif Display', serif; }

        .navbar { 
            background: white; 
            border-bottom: 1px solid rgba(13, 148, 136, 0.1);
            padding: 1.2rem 0;
        }

        .card-custom { 
            border: 1px solid #e5e7eb; 
            border-radius: 24px; 
            box-shadow: 0 10px 40px rgba(13, 148, 136, 0.04); 
            background: white; 
            overflow: hidden;
        }

        .btn-primary { 
            background: var(--primary); 
            border: none; 
            border-radius: 100px; 
            padding: 14px 24px; 
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover { 
            background: var(--primary-dark); 
            transform: translateY(-2px);
        }

        .status-badge { 
            padding: 8px 16px; 
            border-radius: 100px; 
            font-size: 0.8rem; 
            font-weight: 700; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--mint);
        }

        .table thead th { 
            background: #f8fafb; 
            text-transform: uppercase; 
            font-size: 0.7rem; 
            font-weight: 700;
            letter-spacing: 1.5px; 
            color: var(--text-dark); 
            border: none;
            padding: 1.5rem 1rem;
        }

        .table td { vertical-align: middle; padding: 1.5rem 1rem; border-color: #f3f4f6; }
        
        .empty-state { padding: 80px 40px; text-align: center; }
        .icon-box {
            width: 48px;
            height: 48px;
            background: var(--mint);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark serif fs-3" href="#">
            <i class="bi bi-heart-pulse-fill text-primary me-2"></i>VGDH
        </a>
        <div class="ms-auto d-flex align-items-center">
            <div class="text-end me-3 d-none d-md-block">
                <small class="text-muted d-block">Logged in as</small>
                <span class="fw-bold"><?= htmlspecialchars($fullname) ?></span>
            </div>
            <a href="logout.php" class="btn btn-outline-danger rounded-pill px-4 btn-sm fw-bold">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row g-4 justify-content-center">
        
        <div class="col-lg-4">
            <div class="card card-custom p-4 sticky-top" style="top: 2rem; z-index: 10;">
                <h2 class="fw-bold mb-2">Book Appointment</h2>
                <p class="text-muted small mb-4">Complete the form below to request a consultation.</p>

                <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success border-0 rounded-4 small py-3 mb-4 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        Request submitted successfully!
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase opacity-75">Department</label>
                        <select name="department" class="form-select" required>
                            <option value="">Choose Department...</option>
                            <option>General Medicine</option>
                            <option>Cardiology</option>
                            <option>Dermatology</option>
                            <option>Pediatrics</option>
                            <option>Obstetrics & Gynecology</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase opacity-75">Reason for Visit</label>
                        <textarea name="reason" class="form-control" rows="4" placeholder="Briefly describe your symptoms..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 shadow">
                        Submit Request <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-custom">
                <div class="px-4 py-4 border-bottom bg-white d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0">My Health Record</h4>
                    <span class="badge bg-light text-dark rounded-pill px-3 border"><?= $result->num_rows ?> Entries</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Consultation</th>
                                <th>Schedule Info</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-box me-3">
                                                    <i class="bi bi-person-badge fs-5"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark fs-6"><?= $row['department'] ?></div>
                                                    <div class="text-muted small text-truncate" style="max-width: 250px;">
                                                        <?= htmlspecialchars($row['reason']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($row['status'] == 'Approved'): ?>
                                                <div class="text-primary-dark fw-bold">
                                                    <i class="bi bi-calendar-event me-1"></i>
                                                    <?= date('M d, Y', strtotime($row['appointment_date'])) ?>
                                                </div>
                                                <div class="small text-muted ps-4"><?= date('h:i A', strtotime($row['appointment_time'])) ?></div>
                                            <?php else: ?>
                                                <span class="text-muted small"><i class="bi bi-clock-history me-1"></i> TBD by Staff</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php 
                                                $s = $row['status'];
                                                $badgeClass = ($s == 'Approved') ? 'bg-success text-white' : 
                                                              (($s == 'Rejected') ? 'bg-danger text-white' : 'bg-warning text-dark');
                                            ?>
                                            <span class="status-badge <?= $badgeClass ?>"><?= $s ?></span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="empty-state">
                                        <i class="bi bi-clipboard2-pulse fs-1 opacity-25 d-block mb-3"></i>
                                        <h5 class="fw-bold text-dark mb-1">No appointments yet</h5>
                                        <p class="text-muted small">Your medical history will appear here once you book.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>