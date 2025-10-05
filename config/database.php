<?php
/**
 * Enhanced Database Configuration for Zero What Solar CMS
 * Author: Zero What Solar Team
 * Date: 2024
 * 
 * Auto-detects MySQL availability and falls back to SQLite for local testing
 */

// Try MySQL first, fallback to SQLite for local testing
$mysql_available = false;
try {
    $test_pdo = new PDO('mysql:host=localhost', 'root', '');
    $mysql_available = true;
    $test_pdo = null;
} catch (Exception $e) {
    $mysql_available = false;
}

if ($mysql_available) {
    // MySQL Configuration
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'zerowhat_solar_cms');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_CHARSET', 'utf8mb4');
    define('DB_COLLATE', 'utf8mb4_unicode_ci');
    define('DB_TYPE', 'mysql');
} else {
    // SQLite Configuration for local testing
    define('DB_TYPE', 'sqlite');
    define('DB_PATH', __DIR__ . '/../database/local_test.db');
}

// Security settings
define('ADMIN_SESSION_TIMEOUT', 3600); // 1 hour
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutes

class Database {
    private static $instance = null;
    private $connection;
    private $db_type;
    
    private function __construct() {
        if (defined('DB_TYPE') && DB_TYPE === 'sqlite') {
            // SQLite configuration
            $this->db_type = 'sqlite';
            $db_path = DB_PATH;
            
            // Ensure directory exists
            $db_dir = dirname($db_path);
            if (!is_dir($db_dir)) {
                mkdir($db_dir, 0755, true);
            }
            
            try {
                $this->connection = new PDO('sqlite:' . $db_path);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
                // Create admin_users table if it doesn't exist
                $this->createSQLiteTables();
            } catch(PDOException $e) {
                error_log("SQLite Connection Error: " . $e->getMessage());
                throw new PDOException("SQLite connection failed: " . $e->getMessage());
            }
        } else {
            // MySQL configuration
            $this->db_type = 'mysql';
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET . " COLLATE " . DB_COLLATE
            ];
            
            try {
                $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch(PDOException $e) {
                error_log("Database Connection Error: " . $e->getMessage());
                throw new PDOException("Connection failed: " . $e->getMessage());
            }
        }
    }
    
    private function createSQLiteTables() {
        // Create admin_users table for SQLite
        $sql = "CREATE TABLE IF NOT EXISTS admin_users (
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
        )";
        
        $this->connection->exec($sql);
        
        // Check if admin user exists, if not create one
        $stmt = $this->connection->query("SELECT COUNT(*) FROM admin_users WHERE username = 'admin'");
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $this->connection->prepare("INSERT INTO admin_users (username, email, password_hash, full_name, role, is_active) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute(['admin', 'admin@zerowhatsolar.in', $password_hash, 'System Administrator', 'super_admin', 1]);
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
    
    /**
     * Execute a prepared statement with parameters
     */
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
    
    /**
     * Fetch all records
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    /**
     * Fetch single record
     */
    public function fetch($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    /**
     * Insert record and return last insert ID
     */
    public function insert($table, $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        
        return $this->connection->lastInsertId();
    }
    
    /**
     * Update record
     */
    public function update($table, $data, $where, $whereParams = []) {
        $setClause = [];
        foreach($data as $key => $value) {
            $setClause[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setClause);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$where}";
        $params = array_merge($data, $whereParams);
        
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    /**
     * Delete record
     */
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
    
    /**
     * Begin transaction
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    /**
     * Commit transaction
     */
    public function commit() {
        return $this->connection->commit();
    }
    
    /**
     * Rollback transaction
     */
    public function rollback() {
        return $this->connection->rollback();
    }
    
    /**
     * Check if table exists
     */
    public function tableExists($table) {
        try {
            $sql = "SHOW TABLES LIKE '$table'";
            $stmt = $this->connection->query($sql);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Prevent cloning
    private function __clone() {}
    
    // Prevent unserialization
    public function __wakeup() {}
}

// Helper function to get database connection
function getDB() {
    return Database::getInstance()->getConnection();
}

// Helper function to get database instance
function getDBInstance() {
    return Database::getInstance();
}

?>