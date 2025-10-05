<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Debug Login Issues</h2>";

try {
    require_once 'config/database.php';
    echo "✅ Database config loaded<br>";
    
    $db = Database::getInstance();
    $conn = $db->getConnection();
    echo "✅ Database connection successful<br>";
    
    // Check admin user
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute(['admin']);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "✅ Admin user found<br>";
        
        // Test password
        $verify_result = password_verify('admin123', $user['password_hash']);
        
        if ($verify_result) {
            echo "✅ Password verification successful<br>";
        } else {
            echo "❌ Password verification failed - Fixing...<br>";
            
            // Update password
            $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?");
            $update_result = $update_stmt->execute([$new_hash, 'admin']);
            
            if ($update_result) {
                echo "✅ Password updated successfully<br>";
            }
        }
        
    } else {
        echo "❌ Admin user not found - Creating...<br>";
        
        $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
        $insert_sql = "INSERT INTO admin_users (username, email, password_hash, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_result = $insert_stmt->execute([
            'admin',
            'admin@zerowhatsolar.in', 
            $password_hash,
            'System Administrator',
            'super_admin',
            1
        ]);
        
        if ($insert_result) {
            echo "✅ Admin user created<br>";
        }
    }
    
    echo "<h3>Login Ready!</h3>";
    echo "<p><strong>Username:</strong> admin</p>";
    echo "<p><strong>Password:</strong> admin123</p>";
    echo "<p><a href='admin/login.php'>Try Login Now</a></p>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>