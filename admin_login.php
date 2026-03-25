<?php
session_start();

// Hardcoded admin credentials
$admin_username = "admin";
$admin_password = "admin123";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === $admin_username && $password === $admin_password){
        // MATCH THIS TO YOUR DASHBOARD CHECK (Use 'role')
        $_SESSION['role'] = 'admin'; 
        
        // REDIRECT TO THE CORRECT FILENAME
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Access Denied: Invalid Credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Authentication | VGDH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; }
        .admin-card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); width: 100%; max-width: 450px; }
        .admin-header { background: #1e293b; color: white; padding: 40px 20px; text-align: center; }
        .shield-icon { font-size: 3rem; color: #38bdf8; margin-bottom: 10px; }
        .form-container { padding: 40px; }
        .form-label { font-weight: 600; font-size: 0.8rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.025em; }
        .form-control { padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; background-color: #f8fafc; }
        .btn-admin { background-color: #1e293b; border: none; padding: 14px; font-weight: 700; border-radius: 8px; color: white; width: 100%; }
        .alert { border-radius: 8px; font-size: 0.9rem; border: none; background-color: #fef2f2; color: #991b1b; padding: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="admin-card">
    <div class="admin-header">
        <div class="shield-icon"><i class="bi bi-shield-lock-fill"></i></div>
        <h3 class="fw-bold mb-0">Staff Access</h3>
        <p class="text-white-50 small mb-0">Secure Management Terminal</p>
    </div>

    <div class="form-container">
        <?php if(isset($error)): ?>
            <div class="alert d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?= $error ?></div>
            </div>
        <?php endif; ?>

        <form method="POST" action=""> 
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Admin ID" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <button type="submit" name="login" class="btn btn-admin mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i> Authenticate
            </button>
            
            <div class="text-center">
                <a href="index.php" class="text-decoration-none text-muted small">
                    <i class="bi bi-house-door me-1"></i> Return to Main Website
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>