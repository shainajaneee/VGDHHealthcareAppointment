<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['username']; // or 'email' depending on your form
    $password = $_POST['password'];

    // CHANGE THIS: Point it to 'users' instead of 'staff_users'
    $stmt = $conn->prepare("SELECT id, fullname, password, role FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Verify the hashed password
        if (password_hash_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; // This will be 'admin' or 'staff'
            $_SESSION['fullname'] = $user['fullname'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: staff_dashboard.php");
            }
            exit();
        }
    }
    header("Location: admin_login.php?error=invalid_credentials");
}