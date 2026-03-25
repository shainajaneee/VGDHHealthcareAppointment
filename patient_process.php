<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // --- SIGNUP LOGIC ---
    if ($action == 'signup') {
        $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
        $role = 'patient';

        // Check if email already exists
        $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
        if ($check->num_rows > 0) {
            header("Location: patient_register.php?error=Email already registered!");
            exit;
        }

        // Insert new patient
        $sql = "INSERT INTO users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')";
        
        if ($conn->query($sql)) {
            // Log them in immediately after signup
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['role'] = 'patient';
            header("Location: patient_dashboard.php");
        } else {
            header("Location: patient_register.php?error=Registration failed!");
        }
    } 

    // --- LOGIN LOGIC ---
    elseif ($action == 'login') {
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND role = 'patient'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = 'patient';
            header("Location: patient_dashboard.php");
        } else {
            header("Location: patient_register.php?error=Account not found or invalid credentials!");
        }
    }
}
?>