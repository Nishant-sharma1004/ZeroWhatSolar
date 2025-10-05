<?php
/**
 * Quick Admin Login Test
 * Tests the admin login functionality
 */

require_once '../config/database.php';

echo "<h2>🔐 Admin Login Test</h2>";

try {
    $db = Database::getInstance();
    echo "✅ Database connection successful<br>";
    
    // Test admin user existence
    $sql = "SELECT id, username, email, is_active FROM admin_users WHERE username = 'admin'";
    $user = $db->fetch($sql);
    
    if ($user) {
        echo "✅ Admin user found:<br>";
        echo "- ID: " . $user['id'] . "<br>";
        echo "- Username: " . $user['username'] . "<br>";
        echo "- Email: " . $user['email'] . "<br>";
        echo "- Active: " . ($user['is_active'] ? 'Yes' : 'No') . "<br>";
        
        // Test password verification
        $sql = "SELECT password_hash FROM admin_users WHERE username = 'admin'";
        $userData = $db->fetch($sql);
        
        if ($userData && password_verify('admin123', $userData['password_hash'])) {
            echo "✅ Password verification successful<br>";
        } else {
            echo "❌ Password verification failed<br>";
        }
        
        echo "<br><div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px;'>";
        echo "<h3>🎉 Admin Login Ready!</h3>";
        echo "<p><strong>Username:</strong> admin</p>";
        echo "<p><strong>Password:</strong> admin123</p>";
        echo "<p><a href='login.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Login Now</a></p>";
        echo "</div>";
        
    } else {
        echo "❌ Admin user not found<br>";
        echo "Please run the setup script first.<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>

<hr>
<p><a href="../quick_admin_setup.php">← Back to Setup</a> | <a href="login.php">Login Page →</a></p>