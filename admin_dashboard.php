<?php
require_once 'admin_middleware.php';
restrictToAdmin(); 
include 'db.php';

// Stats - Focus on Totals
$total_patients = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='patient'")->fetch_assoc()['c'];
$total_staff = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='staff'")->fetch_assoc()['c'];

// Get all users for the overview table
$result = $conn->query("SELECT id, fullname, email, role, created_at FROM users WHERE role != 'admin' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | VGDH Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --primary: #0d9488; --primary-dark: #0f766e; --mint: #ccfbf1; 
            --cream: #f0fdfa; --sidebar-bg: #134e4a; --text-dark: #1f2937;
            --sidebar-width: 280px;
        }
        
        body { font-family: 'DM Sans', sans-serif; background-color: var(--cream); color: var(--text-dark); }
        h1, h2, h3, .serif { font-family: 'DM Serif Display', serif; }

        .sidebar { 
            width: var(--sidebar-width); height: 100vh; position: fixed; 
            background: var(--sidebar-bg); color: white; z-index: 1050; transition: all 0.3s;
        }
        .sidebar .nav-link { color: #99f6e4; padding: 15px 30px; display: flex; align-items: center; text-decoration: none; transition: 0.3s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: white; border-left: 4px solid var(--mint); }

        .main-content { margin-left: var(--sidebar-width); padding: 40px; }

        .stat-card { 
            border: none; border-radius: 24px; background: white; 
            padding: 30px; box-shadow: 0 10px 30px rgba(13, 148, 136, 0.05);
            transition: transform 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .icon-box { width: 50px; height: 50px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }

        .table-container { background: white; border-radius: 24px; padding: 30px; border: 1px solid #e5e7eb; }
        .search-input { border-radius: 12px; border: 1px solid #e5e7eb; padding: 12px 20px 12px 45px; background: #f9fafb; }

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
        <p class="small text-uppercase tracking-wider opacity-60">Hospital Systems</p>
    </div>
    <nav class="mt-4">
        <a href="admin_dashboard.php" class="nav-link active"><i class="bi bi-grid-fill me-3"></i> Overview</a>
        <a href="manage_staff.php" class="nav-link"><i class="bi bi-shield-lock-fill me-3"></i> Personnel Management</a>
        <hr class="mx-4 opacity-10">
        <a href="logout.php" class="nav-link text-danger"><i class="bi bi-box-arrow-left me-3"></i> Sign Out</a>
    </nav>
</aside>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="display-6 fw-bold mb-1">Health Records Overview</h1>
            <p class="text-muted mb-0">Welcome back, Admin. Here is the current system status.</p>
        </div>
        <button class="btn btn-dark d-lg-none" id="toggleSidebar"><i class="bi bi-list fs-4"></i></button>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="stat-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box bg-mint text-primary"><i class="bi bi-people-fill"></i></div>
                    <span class="ms-3 fw-bold text-muted text-uppercase small">Total Patients</span>
                </div>
                <h2 class="display-5 fw-bold mb-0"><?= $total_patients ?></h2>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="stat-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box bg-light text-dark"><i class="bi bi-person-badge-fill"></i></div>
                    <span class="ms-3 fw-bold text-muted text-uppercase small">Active Staff</span>
                </div>
                <h2 class="display-5 fw-bold mb-0"><?= $total_staff ?></h2>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="stat-card bg-primary text-white">
                <h4 class="serif mb-3">Need to add staff?</h4>
                <p class="small opacity-75 mb-4">You can manage all hospital roles and permissions in the Personnel section.</p>
                <a href="manage_staff.php" class="btn btn-light rounded-pill px-4 fw-bold">Manage Personnel</a>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="serif mb-0">User Directory</h4>
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="searchDir" class="form-control search-input" placeholder="Search accounts...">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dirTable">
                <thead class="table-light">
                    <tr class="small text-uppercase">
                        <th class="ps-4">User</th>
                        <th>Role</th>
                        <th>Joined Date</th>
                        <th class="text-end pe-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold"><?= htmlspecialchars($row['fullname']) ?></div>
                            <div class="text-muted small"><?= htmlspecialchars($row['email']) ?></div>
                        </td>
                        <td>
                            <span class="badge rounded-pill <?= $row['role'] == 'staff' ? 'bg-mint text-primary' : 'bg-light text-dark' ?> px-3">
                                <?= strtoupper($row['role']) ?>
                            </span>
                        </td>
                        <td class="text-muted small"><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                        <td class="text-end pe-4"><span class="text-success fw-bold small">● Active</span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    document.getElementById('toggleSidebar')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('active');
    });

    document.getElementById('searchDir').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('#dirTable tbody tr').forEach(tr => {
            tr.style.display = tr.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>
</body>
</html>