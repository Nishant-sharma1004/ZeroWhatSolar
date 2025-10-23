<?php
/**
 * Admin Logout - Zero What Solar
 */

// Start session
session_start();

// Destroy all session data
session_destroy();

// Redirect to login page with success message
header('Location: login.php?logged_out=1');
exit;
?>