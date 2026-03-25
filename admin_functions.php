<?php
require_once 'admin_middleware.php';
restrictToAdmin(); 
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] === 'create_staff') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username']; 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dept = $_POST['department']; // Make sure this matches your modal select name
    $status = 'Active'; 

    // TARGETING staff_users TABLE
    $stmt = $conn->prepare("INSERT INTO staff_users (fullname, username, password, department, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullname, $username, $password, $dept, $status);
    
    if($stmt->execute()){
        header("Location: manage_staff.php?msg=added");
    } else {
        echo "Error: " . $stmt->error;
    }
    exit();
}
}
    // ACTION: RESET PASSWORD
    if ($_POST['action'] === 'reset_staff_password') {
        $id = intval($_POST['staff_id']);
        $new_pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_pass, $id);
        
        if($stmt->execute()){
            header("Location: manage_staff.php?msg=reset_success");
        } else {
            header("Location: manage_staff.php?msg=error");
        }
        exit();
    }


// ACTION: DELETE USER
if(isset($_GET['delete_id'])){
    $del_id = intval($_GET['delete_id']);
    
    // Safety check: Prevent deleting yourself (the current logged-in admin)
    if($del_id == $_SESSION['user_id']) {
        header("Location: manage_staff.php?msg=cannot_delete_self");
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $del_id);
    
    if($stmt->execute()){
        header("Location: manage_staff.php?msg=deleted");
    } else {
        header("Location: manage_staff.php?msg=error");
    }
    exit();
}