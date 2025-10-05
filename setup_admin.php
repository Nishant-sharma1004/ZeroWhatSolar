<?php
/**
 * Admin User Setup and Database Test
 * Zero What Solar CMS
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

echo "<h2>Admin Login Setup & Database Test</h2>";

try {
    // Test database connection
    $db = Database::getInstance();
    $conn = $db->getConnection();
    echo "✅ Database connection successful<br>";
    
    // Check if admin_users table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'admin_users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ admin_users table exists<br>";
        
        // Check existing admin users
        $stmt = $conn->query("SELECT id, username, email, is_active FROM admin_users");
        $users = $stmt->fetchAll();
        
        echo "<h3>Existing Admin Users:</h3>";
        if (empty($users)) {
            echo "❌ No admin users found<br>";
            
            // Create default admin user
            echo "<h3>Creating default admin user...</h3>";
            
            $defaultPassword = 'admin123';
            $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO admin_users (username, email, password_hash, full_name, role, is_active, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())";
            
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'admin',
                'admin@zerowhatsolar.in',
                $hashedPassword,
                'System Administrator',
                'super_admin',
                1
            ]);
            
            if ($result) {
                echo "✅ Default admin user created successfully<br>";
                echo "<strong>Username:</strong> admin<br>";
                echo "<strong>Password:</strong> admin123<br>";
                echo "<strong>Email:</strong> admin@zerowhatsolar.in<br>";
            } else {
                echo "❌ Failed to create admin user<br>";
            }
            
        } else {
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Active</th><th>Test Login</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($user['id']) . "</td>";
                echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                echo "<td>" . ($user['is_active'] ? '✅' : '❌') . "</td>";
                
                // Test password verification for known users
                if ($user['username'] === 'admin') {
                    $testStmt = $conn->prepare("SELECT password_hash FROM admin_users WHERE username = ?");
                    $testStmt->execute(['admin']);
                    $userRecord = $testStmt->fetch();
                    
                    if ($userRecord && password_verify('admin123', $userRecord['password_hash'])) {
                        echo "<td>✅ Password OK</td>";
                    } else {
                        echo "<td>❌ Password Failed</td>";
                    }
                } else {
                    echo "<td>-</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "❌ admin_users table does not exist<br>";
        echo "<h3>Creating admin_users table...</h3>";
        
        $createTableSQL = "
        CREATE TABLE admin_users (
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
        )";
        
        if ($conn->exec($createTableSQL)) {
            echo "✅ admin_users table created<br>";
            
            // Create default admin user
            $defaultPassword = 'admin123';
            $hashedPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO admin_users (username, email, password_hash, full_name, role, is_active) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'admin',
                'admin@zerowhatsolar.in',
                $hashedPassword,
                'System Administrator',
                'super_admin',
                1
            ]);
            
            if ($result) {
                echo "✅ Default admin user created<br>";
                echo "<strong>Username:</strong> admin<br>";
                echo "<strong>Password:</strong> admin123<br>";
            } else {
                echo "❌ Failed to create admin user<br>";
            }
        } else {
            echo "❌ Failed to create admin_users table<br>";
        }
    }
    
    // Check if admin_sessions table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'admin_sessions'");
    if ($stmt->rowCount() == 0) {
        echo "<h3>Creating admin_sessions table...</h3>";
        
        $createSessionsSQL = "
        CREATE TABLE admin_sessions (
            id VARCHAR(64) PRIMARY KEY,
            admin_id INT NOT NULL,
            ip_address VARCHAR(45),
            user_agent TEXT,
            last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            expires_at DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (admin_id) REFERENCES admin_users(id) ON DELETE CASCADE
        )";
        
        if ($conn->exec($createSessionsSQL)) {
            echo "✅ admin_sessions table created<br>";
        } else {
            echo "❌ Failed to create admin_sessions table<br>";
        }
    } else {
        echo "✅ admin_sessions table exists<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage() . "<br>";
    echo "Please ensure:<br>";
    echo "1. XAMPP MySQL is running<br>";
    echo "2. Database 'zerowhat_solar_cms' exists<br>";
    echo "3. PHP can connect to MySQL<br>";
}

echo "<hr>";
echo "<p><strong>Once everything is set up, try logging in at:</strong> <a href='admin/login.php'>admin/login.php</a></p>";
?>