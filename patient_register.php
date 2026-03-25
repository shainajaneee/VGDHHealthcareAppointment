<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Access - VGDH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .auth-card {
            border: none;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .auth-toggle {
            background: #f1f5f9;
            padding: 5px;
            border-radius: 12px;
            display: flex;
            margin-bottom: 2rem;
        }
        .auth-toggle .btn {
            flex: 1;
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            transition: 0.3s;
        }
        .auth-toggle .active {
            background: #fff !important;
            color: #0d6efd !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #475569; }
        .input-group-text { background: transparent; border-right: none; color: #94a3b8; }
        .form-control { border-left: none; padding: 12px; }
        .form-control:focus { box-shadow: none; border-color: #dee2e6; }
        .btn-submit { padding: 14px; font-weight: 700; border-radius: 12px; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card auth-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="text-primary fs-1 mb-2">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <h2 class="fw-bold h4">Patient Portal</h2>
                    <p class="text-muted small">Manage your health records and bookings</p>
                </div>

                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger small py-2"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php endif; ?>

                <div class="auth-toggle">
                    <button class="btn active" id="loginToggle">Login</button>
                    <button class="btn" id="signupToggle">Sign Up</button>
                </div>

                <form id="loginForm" method="POST" action="patient_process.php">
                    <input type="hidden" name="action" value="login">
                    <div class="mb-3">
                        <label class="form-label text-uppercase">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="name@email.com" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-uppercase">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-submit shadow">Sign In</button>
                </form>

                <form id="signupForm" method="POST" action="patient_process.php" style="display: none;">
                    <input type="hidden" name="action" value="signup">
                    <div class="mb-3">
                        <label class="form-label text-uppercase">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="fullname" class="form-control" placeholder="John Doe" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-uppercase">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="name@email.com" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-uppercase">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Create a password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-submit shadow">Create Account</button>
                </form>

                <div class="text-center mt-4">
                    <a href="index.php" class="text-decoration-none small text-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Homepage
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const loginToggle = document.getElementById('loginToggle');
    const signupToggle = document.getElementById('signupToggle');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');

    loginToggle.addEventListener('click', () => {
        loginForm.style.display = 'block';
        signupForm.style.display = 'none';
        loginToggle.classList.add('active');
        signupToggle.classList.remove('active');
    });

    signupToggle.addEventListener('click', () => {
        signupForm.style.display = 'block';
        loginForm.style.display = 'none';
        signupToggle.classList.add('active');
        loginToggle.classList.remove('active');
    });
</script>

</body>
</html>