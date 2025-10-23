<?php
<?php
// Admin authentication helper
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAdminAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit();
    }
    
    // Check session timeout (8 hours)
    if (isset($_SESSION['admin_login_time']) && (time() - $_SESSION['admin_login_time'] > 28800)) {
        session_destroy();
        header('Location: login.php?timeout=1');
        exit();
    }
}

function logoutAdmin() {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Auto-logout if requested
if (isset($_GET['logout'])) {
    logoutAdmin();
}
?>