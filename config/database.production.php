<?php
/**
 * Production Database Configuration for Hostinger
 * Replace these values with your Hostinger database credentials
 */

// Production Database Configuration (Hostinger)
define('DB_HOST', 'localhost'); // Usually localhost for Hostinger
define('DB_NAME', 'u123456789_zerowhat'); // Your actual database name from Hostinger
define('DB_USER', 'u123456789_admin'); // Your database username from Hostinger
define('DB_PASS', 'YourSecurePassword123!'); // Your database password from Hostinger
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

// Security settings for production
define('ADMIN_SESSION_TIMEOUT', 3600); // 1 hour
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutes

// Production environment settings
define('ENVIRONMENT', 'production');
define('DEBUG_MODE', false);
define('ERROR_REPORTING', false);

// Site URL for production
define('SITE_URL', 'https://zerowhatsolar.in'); // Your actual domain
define('ADMIN_URL', 'https://zerowhatsolar.in/admin');

// Email configuration for production
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'noreply@zerowhatsolar.in'); // Your domain email
define('SMTP_PASSWORD', 'YourEmailPassword'); // Your email password
define('SMTP_FROM_EMAIL', 'noreply@zerowhatsolar.in');
define('SMTP_FROM_NAME', 'Zero What Solar');

// WhatsApp Business API (if using)
define('WHATSAPP_BUSINESS_PHONE', '+919876543210');
define('WHATSAPP_API_TOKEN', 'your_whatsapp_api_token_here');

class Database {
    private static $instance = null;
    private $connection;
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $charset = DB_CHARSET;
    
    private function __construct() {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $this->charset . " COLLATE " . DB_COLLATE,
            PDO::ATTR_PERSISTENT => true // Enable persistent connections for better performance
        ];
        
        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $e) {
            if (DEBUG_MODE) {
                error_log("Database Connection Error: " . $e->getMessage());
                throw new PDOException("Connection failed: " . $e->getMessage());
            } else {
                // In production, don't reveal database errors
                throw new PDOException("Database connection failed. Please try again later.");
            }
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
            if (DEBUG_MODE) {
                error_log("Database Error: " . $e->getMessage());
                throw $e;
            } else {
                throw new PDOException("Database operation failed. Please try again later.");
            }
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

// Production error handling
if (!DEBUG_MODE) {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/php-errors.log');
}

?>