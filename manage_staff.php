<?php
require_once 'admin_middleware.php';
restrictToAdmin(); 
include 'db.php';

// Fetch Staff AND Patients for management (as requested)
// We use the 'users' table since we are consolidating everything there
// Fetch ONLY Staff Members from the staff_users table
$staff_result = $conn->query("SELECT * FROM staff_users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel Management | VGDH Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --primary: #0d9488; --primary-dark: #0f766e; --mint: #ccfbf1; 
            --cream: #f0fdfa; --sidebar-bg: #134e4a; --text-dark: #1f2937;
            --sidebar-width: 280px;
        }
        
        body { font-family: 'DM Sans', sans-serif; background-color: var(--cream); color: var(--text-dark); overflow-x: hidden; }
        h1, h2, h3, h4, .serif { font-family: 'DM Serif Display', serif; }

        .sidebar { 
            width: var(--sidebar-width); height: 100vh; position: fixed; left: 0; top: 0;
            background: var(--sidebar-bg); color: white; z-index: 1050; transition: all 0.3s;
        }
        .sidebar .nav-link { color: #99f6e4; padding: 15px 30px; display: flex; align-items: center; text-decoration: none; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: white; border-left: 4px solid var(--mint); }

        .main-content { margin-left: var(--sidebar-width); padding: 40px; }

        .table-container { background: white; border-radius: 24px; padding: 30px; border: 1px solid #e5e7eb; box-shadow: 0 10px 30px rgba(13, 148, 136, 0.03); }
        
        .badge-staff { background: var(--mint); color: var(--primary-dark); }
        .badge-patient { background: #f3f4f6; color: #4b5563; }
        
        .form-control, .form-select { border-radius: 12px; padding: 12px; border: 1px solid #e5e7eb; background: #f9fafb; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1); }

        .btn-primary { background: var(--primary); border: none; }
        .btn-primary:hover { background: var(--primary-dark); }

        @media (max-width: 992px) {
            .sidebar { left: -280px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>
<body>

<aside class="sidebar" id="sidebar">
    <div class="p-4 mt-2">
        <h2 class="fw-bold text-white mb-0 serif">VGDH</h2>
        <p class="small text-uppercase opacity-60">Hospital Systems</p>
    </div>
    <nav class="mt-4">
        <a href="admin_dashboard.php" class="nav-link"><i class="bi bi-grid-fill me-3"></i> Overview</a>
        <a href="manage_staff.php" class="nav-link active"><i class="bi bi-shield-lock-fill me-3"></i> Personnel Management</a>
        <hr class="mx-4 opacity-10">
        <a href="logout.php" class="nav-link text-danger"><i class="bi bi-box-arrow-left me-3"></i> Sign Out</a>
    </nav>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="display-6 fw-bold mb-1">Personnel Management</h1>
            <p class="text-muted mb-0">Manage all system users, both medical staff and registered patients.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-dark d-lg-none" id="toggleSidebar"><i class="bi bi-list fs-4"></i></button>
            <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="bi bi-person-plus-fill me-2"></i>Create Staff Account
            </button>
        </div>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 alert-dismissible fade show mb-4 bg-mint text-primary-dark" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> User records updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted small text-uppercase">
                        <th class="ps-3">Name & Role</th>
                        <th>Email / Username</th>
                        <th>Registered Date</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($staff_result->num_rows > 0): while($s = $staff_result->fetch_assoc()): ?>
                    <tr>
                     <td class="ps-3">
    <div class="fw-bold text-dark"><?= htmlspecialchars($s['fullname']) ?></div>
    
    <span class="badge rounded-pill badge-staff small">
        STAFF
    </span>
</td>
<td><span class="text-muted"><?= htmlspecialchars($s['username']) ?></span></td>
<td class="small"><?= isset($s['created_at']) ? date('M d, Y', strtotime($s['created_at'])) : 'N/A' ?></td>
                        <td class="text-end pe-3">
                            <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold" onclick="openResetModal(<?= $s['id'] ?>, '<?= addslashes($s['fullname']) ?>')">
                                <i class="bi bi-key-fill"></i> Reset
                            </button>
                            <a href="admin_functions.php?delete_id=<?= $s['id'] ?>" class="btn btn-outline-danger btn-sm rounded-pill ms-1" onclick="return confirm('Permanently remove this account?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="4" class="text-center py-5 text-muted">No accounts found in system.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="addStaffModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-5">
            <form action="admin_functions.php" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="action" value="create_staff">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="fullname" class="form-control" placeholder="Dr. Juan Dela Cruz" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username / Staff ID</label>
                        <input type="text" name="username" class="form-control" placeholder="vgdh_staff01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Department</label>
                        <select name="department" class="form-select" required>
                            <option value="General Medicine">General Medicine</option>
                            <option value="OPD">Outpatient (OPD)</option>
                            <option value="Pediatrics">Pediatrics</option>
                            <option value="Dental">Dental</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Temporary Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Save to Staff Records</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-5">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="serif h4 fw-bold">Reset Staff Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="admin_functions.php" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="action" value="reset_staff_password">
                    <input type="hidden" name="staff_id" id="reset_user_id">
                    
                    <p class="text-muted">Resetting password for: <br>
                        <strong id="reset_user_name" class="text-primary fs-5"></strong>
                    </p>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">New Password</label>
                        <input type="password" name="new_password" class="form-control" required minlength="6">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Update Staff Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar Toggle
    document.getElementById('toggleSidebar')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('active');
    });

    // Reset Password Modal Logic
    function openResetModal(id, name) {
        const modalElement = document.getElementById('resetPasswordModal');
        if (modalElement) {
            document.getElementById('reset_user_id').value = id;
            document.getElementById('reset_user_name').innerText = name;
            const myModal = new bootstrap.Modal(modalElement);
            myModal.show();
        }
    }
</script>
</body>
</html>