<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Middleware: This is the logic. 
 * It ONLY works if you CALL the function in your other files.
 */
function restrictToAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: admin_login.php?error=unauthorized");
        exit(); // This stops the rest of the page from loading
    }
}
?>