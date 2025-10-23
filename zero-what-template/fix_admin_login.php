<?php
/**
 * Fix Admin Login - Create Database and Admin User
 * Zero What Solar CMS
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Admin Login Fix Script</h1>";
echo "<p>This script will create the database and admin user needed for login.</p>";

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'zerowhat_solar_cms';

try {
    // Connect to MySQL server (without selecting database)
    echo "<h2>Step 1: Connecting to MySQL Server...</h2>";
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to MySQL server successfully<br>";
    
    // Create database if it doesn't exist
    echo "<h2>Step 2: Creating Database...</h2>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$dbname' created/verified<br>";
    
    // Connect to the specific database
    echo "<h2>Step 3: Connecting to Database...</h2>";
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to database '$dbname'<br>";
    
    // Create admin_users table
    echo "<h2>Step 4: Creating Admin Users Table...</h2>";
    $createTableSQL = "
    CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        role ENUM('editor', 'admin', 'super_admin') DEFAULT 'admin',
        is_active BOOLEAN DEFAULT TRUE,
        failed_login_attempts INT DEFAULT 0,
        locked_until DATETIME NULL,
        last_login DATETIME NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    
    $pdo->exec($createTableSQL);
    echo "✅ Admin users table created/verified<br>";
    
    // Check if admin user already exists
    echo "<h2>Step 5: Setting up Admin User...</h2>";
    $stmt = $pdo->prepare("SELECT id, username FROM admin_users WHERE username = 'admin'");
    $stmt->execute();
    $existingAdmin = $stmt->fetch();
    
    if ($existingAdmin) {
        echo "⚠️ Admin user already exists (ID: {$existingAdmin['id']})<br>";
        
        // Update the password to ensure it works
        $newPassword = 'admin123';
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("UPDATE admin_users SET password_hash = ?, is_active = 1 WHERE username = 'admin'");
        $stmt->execute([$hashedPassword]);
        echo "✅ Admin password updated to ensure login works<br>";
        
    } else {
        // Create new admin user
        $adminPassword = 'admin123';
        $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("
            INSERT INTO admin_users (username, email, password_hash, full_name, role, is_active) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $result = $stmt->execute([
            'admin',
            'admin@zerowhatsolar.in',
            $hashedPassword,
            'System Administrator',
            'super_admin',
            1
        ]);
        
        if ($result) {
            echo "✅ New admin user created successfully<br>";
        } else {
            echo "❌ Failed to create admin user<br>";
        }
    }
    
    // Verify login credentials
    echo "<h2>Step 6: Verifying Login Credentials...</h2>";
    $stmt = $pdo->prepare("SELECT id, username, email, password_hash, is_active FROM admin_users WHERE username = 'admin'");
    $stmt->execute();
    $admin = $stmt->fetch();
    
    if ($admin) {
        echo "✅ Admin user found:<br>";
        echo "&nbsp;&nbsp;&nbsp;ID: {$admin['id']}<br>";
        echo "&nbsp;&nbsp;&nbsp;Username: {$admin['username']}<br>";
        echo "&nbsp;&nbsp;&nbsp;Email: {$admin['email']}<br>";
        echo "&nbsp;&nbsp;&nbsp;Active: " . ($admin['is_active'] ? 'Yes' : 'No') . "<br>";
        
        // Test password verification
        if (password_verify('admin123', $admin['password_hash'])) {
            echo "✅ Password verification: SUCCESS<br>";
        } else {
            echo "❌ Password verification: FAILED<br>";
        }
    } else {
        echo "❌ Admin user not found<br>";
    }
    
    // Create other essential tables
    echo "<h2>Step 7: Creating Essential Tables...</h2>";
    
    $tables = [
        'site_settings' => "
            CREATE TABLE IF NOT EXISTS site_settings (
                id INT AUTO_INCREMENT PRIMARY KEY,
                setting_key VARCHAR(100) UNIQUE NOT NULL,
                setting_value TEXT,
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB",
        
        'site_statistics' => "
            CREATE TABLE IF NOT EXISTS site_statistics (
                id INT AUTO_INCREMENT PRIMARY KEY,
                stat_name VARCHAR(100) NOT NULL,
                stat_value VARCHAR(50) NOT NULL,
                stat_label VARCHAR(100) NOT NULL,
                is_active BOOLEAN DEFAULT TRUE,
                display_order INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB",
        
        'testimonials' => "
            CREATE TABLE IF NOT EXISTS testimonials (
                id INT AUTO_INCREMENT PRIMARY KEY,
                client_name VARCHAR(100) NOT NULL,
                client_designation VARCHAR(100),
                client_company VARCHAR(100),
                testimonial_text TEXT NOT NULL,
                rating INT DEFAULT 5,
                featured BOOLEAN DEFAULT FALSE,
                status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB"
    ];
    
    foreach ($tables as $tableName => $sql) {
        $pdo->exec($sql);
        echo "✅ Table '$tableName' created/verified<br>";
    }
    
    echo "<h2>🎉 Setup Complete!</h2>";
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>✅ Login Credentials:</h3>";
    echo "<p><strong>Username:</strong> admin</p>";
    echo "<p><strong>Password:</strong> admin123</p>";
    echo "<p><strong>Admin URL:</strong> <a href='admin/login.php' target='_blank'>admin/login.php</a></p>";
    echo "</div>";
    
    echo "<p><strong>✅ Database Setup Complete!</strong> You should now be able to login to the admin panel.</p>";

} catch (PDOException $e) {
    echo "<h2>❌ Database Error:</h2>";
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<h3>🔧 Troubleshooting Steps:</h3>";
    echo "<ol>";
    echo "<li>Make sure XAMPP/WAMP is running</li>";
    echo "<li>Make sure MySQL service is started</li>";
    echo "<li>Check if port 3306 is available</li>";
    echo "<li>Verify MySQL root user has no password (default XAMPP setup)</li>";
    echo "</ol>";
} catch (Exception $e) {
    echo "<h2>❌ General Error:</h2>";
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>