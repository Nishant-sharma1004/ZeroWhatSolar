<?php
/**
 * Debug Admin Login
 * Helps diagnose login issues
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/database.php';

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h2>🔍 Admin Login Debug</h2>";

// Test database connection
try {
    $db = Database::getInstance();
    echo "✅ Database connection successful<br>";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// Check admin users table
try {
    $users = $db->fetchAll("SELECT id, username, email, is_active FROM admin_users");
    echo "✅ Admin users table accessible<br>";
    echo "Found " . count($users) . " users:<br>";
    
    foreach ($users as $user) {
        echo "- ID: {$user['id']}, Username: {$user['username']}, Email: {$user['email']}, Active: " . ($user['is_active'] ? 'Yes' : 'No') . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Error reading admin users: " . $e->getMessage() . "<br>";
}

// Test specific admin user
try {
    $sql = "SELECT id, username, email, password_hash, is_active FROM admin_users WHERE username = 'admin'";
    $admin = $db->fetch($sql);
    
    if ($admin) {
        echo "<br>✅ Admin user found:<br>";
        echo "- ID: {$admin['id']}<br>";
        echo "- Username: {$admin['username']}<br>";
        echo "- Email: {$admin['email']}<br>";
        echo "- Active: " . ($admin['is_active'] ? 'Yes' : 'No') . "<br>";
        echo "- Password hash: " . substr($admin['password_hash'], 0, 20) . "...<br>";
        
        // Test password verification
        $testPassword = 'admin123';
        if (password_verify($testPassword, $admin['password_hash'])) {
            echo "✅ Password 'admin123' verification: SUCCESS<br>";
        } else {
            echo "❌ Password 'admin123' verification: FAILED<br>";
            
            // Try creating a new password hash
            $newHash = password_hash($testPassword, PASSWORD_DEFAULT);
            echo "New hash would be: " . substr($newHash, 0, 20) . "...<br>";
            
            // Update the password
            try {
                $updateSql = "UPDATE admin_users SET password_hash = ? WHERE username = 'admin'";
                $db->query($updateSql, [$newHash]);
                echo "✅ Password updated successfully<br>";
            } catch (Exception $e) {
                echo "❌ Failed to update password: " . $e->getMessage() . "<br>";
            }
        }
    } else {
        echo "❌ Admin user 'admin' not found<br>";
        
        // Create admin user
        echo "Creating admin user...<br>";
        try {
            $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
            $sql = "INSERT INTO admin_users (username, email, password_hash, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, ?)";
            $db->query($sql, ['admin', 'admin@zerowhatsolar.in', $password_hash, 'System Administrator', 'super_admin', 1]);
            echo "✅ Admin user created successfully<br>";
        } catch (Exception $e) {
            echo "❌ Failed to create admin user: " . $e->getMessage() . "<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Error checking admin user: " . $e->getMessage() . "<br>";
}

// Test login process simulation
if ($_POST) {
    echo "<br><h3>🔍 Login Process Debug</h3>";
    
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    echo "Attempting login with:<br>";
    echo "- Username: '$username'<br>";
    echo "- Password: '$password'<br>";
    
    if (empty($username) || empty($password)) {
        echo "❌ Empty username or password<br>";
    } else {
        try {
            $sql = "SELECT id, username, email, password_hash, full_name, role, is_active 
                    FROM admin_users 
                    WHERE (username = :username OR email = :username) AND is_active = 1";
            
            echo "SQL Query: $sql<br>";
            echo "Parameter: username = '$username'<br>";
            
            $user = $db->fetch($sql, ['username' => $username]);
            
            if ($user) {
                echo "✅ User found:<br>";
                echo "- ID: {$user['id']}<br>";
                echo "- Username: {$user['username']}<br>";
                echo "- Active: " . ($user['is_active'] ? 'Yes' : 'No') . "<br>";
                
                if (password_verify($password, $user['password_hash'])) {
                    echo "✅ Password verification: SUCCESS<br>";
                    echo "🎉 Login would be successful!<br>";
                } else {
                    echo "❌ Password verification: FAILED<br>";
                    echo "Stored hash: " . substr($user['password_hash'], 0, 30) . "...<br>";
                }
            } else {
                echo "❌ User not found or inactive<br>";
            }
            
        } catch (Exception $e) {
            echo "❌ Login error: " . $e->getMessage() . "<br>";
        }
    }
}
?>

<hr>
<h3>🧪 Test Login</h3>
<form method="POST">
    <p>
        <label>Username:</label><br>
        <input type="text" name="username" value="admin" style="padding: 5px; width: 200px;">
    </p>
    <p>
        <label>Password:</label><br>
        <input type="password" name="password" value="admin123" style="padding: 5px; width: 200px;">
    </p>
    <p>
        <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px;">Test Login</button>
    </p>
</form>

<hr>
<p><a href="login.php">← Back to Login Page</a></p>