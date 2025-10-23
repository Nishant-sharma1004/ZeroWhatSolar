<?php
/**
 * Quick Database Setup for Local Testing
 * Uses SQLite for local testing when MySQL is not available
 */

// Check if we can connect to MySQL first
try {
    $mysql_available = false;
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    $mysql_available = true;
    $pdo = null;
} catch (Exception $e) {
    $mysql_available = false;
}

if (!$mysql_available) {
    echo "<h2>🔄 Setting up SQLite Database for Local Testing</h2>";
    
    // Create SQLite database
    $db_path = __DIR__ . '/database/local_test.db';
    $db_dir = dirname($db_path);
    
    if (!is_dir($db_dir)) {
        mkdir($db_dir, 0755, true);
    }
    
    try {
        $pdo = new PDO('sqlite:' . $db_path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create admin_users table
        $pdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            full_name VARCHAR(100) NOT NULL,
            role VARCHAR(20) DEFAULT 'admin',
            is_active INTEGER DEFAULT 1,
            failed_login_attempts INTEGER DEFAULT 0,
            locked_until DATETIME NULL,
            last_login DATETIME NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Check if admin user exists
        $stmt = $pdo->query("SELECT COUNT(*) FROM admin_users WHERE username = 'admin'");
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            // Create default admin user
            $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admin_users (username, email, password_hash, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(['admin', 'admin@zerowhatsolar.in', $password_hash, 'System Administrator', 'super_admin', 1]);
            
            echo "✅ SQLite database created successfully<br>";
            echo "✅ Admin user created<br>";
        } else {
            echo "✅ SQLite database and admin user already exist<br>";
        }
        
        echo "<h3>📝 Login Credentials:</h3>";
        echo "<strong>Username:</strong> admin<br>";
        echo "<strong>Password:</strong> admin123<br>";
        echo "<strong>Login URL:</strong> <a href='admin/login.php'>admin/login.php</a><br>";
        
        // Update database config to use SQLite
        $config_content = '<?php
/**
 * Local SQLite Database Configuration
 * For testing when MySQL is not available
 */

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        $db_path = __DIR__ . "/../database/local_test.db";
        try {
            $this->connection = new PDO("sqlite:" . $db_path);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new PDOException("SQLite Connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    public function fetch($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    public function insert($table, $data) {
        $columns = implode(",", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        
        return $this->connection->lastInsertId();
    }
    
    public function update($table, $data, $where, $whereParams = []) {
        $setClause = [];
        foreach($data as $key => $value) {
            $setClause[] = "{$key} = :{$key}";
        }
        $setClause = implode(", ", $setClause);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $params = array_merge($data, $whereParams);
        
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    public function commit() {
        return $this->connection->commit();
    }
    
    public function rollback() {
        return $this->connection->rollback();
    }
    
    public function tableExists($table) {
        try {
            $sql = "SELECT name FROM sqlite_master WHERE type=\'table\' AND name=?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$table]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }
    
    private function __clone() {}
    public function __wakeup() {}
}

function getDB() {
    return Database::getInstance()->getConnection();
}

function getDBInstance() {
    return Database::getInstance();
}
?>';
        
        file_put_contents(__DIR__ . '/config/database.local.php', $config_content);
        
        echo "<br>✅ Local SQLite configuration created<br>";
        echo "<p style='color: green;'><strong>✅ Setup Complete! You can now login to the admin panel.</strong></p>";
        
    } catch (Exception $e) {
        echo "❌ Error setting up SQLite: " . $e->getMessage();
    }
    
} else {
    echo "<h2>✅ MySQL is available - redirecting to standard setup</h2>";
    header('Location: setup_admin.php');
    exit;
}
?>

<hr>
<p><a href="admin/login.php" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">🚀 Go to Admin Login</a></p>