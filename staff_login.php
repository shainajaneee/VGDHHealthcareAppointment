<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_user = $_POST['username'];
    $input_pass = $_POST['password'];

    /**
     * FIX: Changed 'email' to 'username' to match your staff_users table.
     * Also ensured it checks for 'Active' status as per your requirement.
     */
    $stmt = $conn->prepare("SELECT * FROM staff_users WHERE username = ? AND status = 'Active' LIMIT 1");
    
    // We only need to bind the input once now because we are checking 'username'
    $stmt->bind_param("s", $input_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc();
        
        // Verify the hashed password
        if (password_verify($input_pass, $staff['password'])) {
            // Setting Sessions
            $_SESSION['staff_id'] = $staff['id'];
            $_SESSION['fullname'] = $staff['fullname'];
            $_SESSION['role'] = 'staff'; // Hardcoded since they are in staff_users
            
            // Handle department if it exists, otherwise default to 'General'
            $_SESSION['dept'] = $staff['department'] ?? 'General';
            
            header("Location: staff_dashboard.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Staff account not found or inactive.";
    }
}
?>
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login | VGDH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f4f7fe; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh;
            margin: 0;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
        }
        .form-control {
            padding: 15px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            font-size: 1.1rem;
        }
        .form-control:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        }
        .btn-login {
            padding: 15px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            background: #0f172a;
            color: white;
            border: none;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #1e293b;
            transform: translateY(-2px);
        }
        .btn-admin {
            border: 2px solid #e2e8f0;
            color: #64748b;
            border-radius: 12px;
            padding: 10px;
            font-weight: 600;
            transition: 0.2s;
            text-decoration: none;
            display: inline-block;
            width: 100%;
        }
        .btn-admin:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #cbd5e1;
            margin: 25px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        .divider:not(:empty)::before { margin-right: .5em; }
        .divider:not(:empty)::after { margin-left: .5em; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="display-6 text-info mb-2"><i class="bi bi-heart-pulse-fill"></i></div>
            <h2 class="fw-bold">Staff Portal</h2>
            <p class="text-muted">Enter your credentials to manage appointments.</p>
        </div>

        <?php if($error): ?>
            <div class="alert alert-danger border-0 rounded-3 small text-center"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold small text-uppercase">Username / Staff ID</label>
                <input type="text" name="username" class="form-control" placeholder="e.g. staff_01" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold small text-uppercase">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-login w-100 shadow-sm mb-2">Sign In to Dashboard</button>
        </form>

        <div class="divider small fw-bold">OR</div>
        
        <div class="text-center">
            <a href="admin_login.php" class="btn-admin mb-3">
                <i class="bi bi-person-badge-fill me-2"></i>Admin Access
            </a>
            
            <a href="index.php" class="text-decoration-none small text-muted d-block">
                <i class="bi bi-arrow-left me-1"></i> Back to Home
            </a>
        </div>
    </div>
</div>

</body>
</html>