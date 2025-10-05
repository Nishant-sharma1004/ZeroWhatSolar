<?php
/**
 * Admin Authentication Functions
 * Zero What Solar CMS
 */

require_once '../config/database.php';

class AdminAuth {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Login admin user
     */
    public function login($username, $password) {
        try {
            $sql = "SELECT id, username, email, password_hash, full_name, role, is_active, failed_login_attempts, locked_until 
                    FROM admin_users 
                    WHERE (username = :username OR email = :username) AND is_active = 1";
            
            $user = $this->db->fetch($sql, ['username' => $username]);
            
            if (!$user) {
                return ['success' => false, 'message' => 'Invalid credentials'];
            }
            
            // Check if account is locked
            if ($user['locked_until'] && strtotime($user['locked_until']) > time()) {
                return ['success' => false, 'message' => 'Account is temporarily locked. Please try again later.'];
            }
            
            // Verify password
            if (!password_verify($password, $user['password_hash'])) {
                $this->handleFailedLogin($user['id']);
                return ['success' => false, 'message' => 'Invalid credentials'];
            }
            
            // Clear failed login attempts
            $this->clearFailedLoginAttempts($user['id']);
            
            // Create session
            $sessionId = $this->createSession($user);
            
            // Update last login
            $this->updateLastLogin($user['id']);
            
            return [
                'success' => true,
                'user' => $user,
                'session_id' => $sessionId
            ];
            
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Login failed. Please try again.'];
        }
    }
    
    /**
     * Handle failed login attempt
     */
    private function handleFailedLogin($userId) {
        $sql = "UPDATE admin_users 
                SET failed_login_attempts = failed_login_attempts + 1,
                    locked_until = CASE 
                        WHEN failed_login_attempts >= :max_attempts THEN DATE_ADD(NOW(), INTERVAL :lockout_time SECOND)
                        ELSE locked_until 
                    END
                WHERE id = :user_id";
        
        $this->db->query($sql, [
            'max_attempts' => MAX_LOGIN_ATTEMPTS - 1,
            'lockout_time' => LOCKOUT_TIME,
            'user_id' => $userId
        ]);
    }
    
    /**
     * Clear failed login attempts
     */
    private function clearFailedLoginAttempts($userId) {
        $sql = "UPDATE admin_users SET failed_login_attempts = 0, locked_until = NULL WHERE id = :user_id";
        $this->db->query($sql, ['user_id' => $userId]);
    }
    
    /**
     * Create admin session
     */
    private function createSession($user) {
        $sessionId = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + ADMIN_SESSION_TIMEOUT);
        
        $sql = "INSERT INTO admin_sessions (id, admin_id, ip_address, user_agent, expires_at) 
                VALUES (:session_id, :admin_id, :ip_address, :user_agent, :expires_at)";
        
        $this->db->query($sql, [
            'session_id' => $sessionId,
            'admin_id' => $user['id'],
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'expires_at' => $expiresAt
        ]);
        
        // Set session cookie
        setcookie('admin_session', $sessionId, time() + ADMIN_SESSION_TIMEOUT, '/admin/', '', true, true);
        
        return $sessionId;
    }
    
    /**
     * Update last login time
     */
    private function updateLastLogin($userId) {
        $sql = "UPDATE admin_users SET last_login = NOW() WHERE id = :user_id";
        $this->db->query($sql, ['user_id' => $userId]);
    }
    
    /**
     * Check if user is authenticated
     */
    public function isAuthenticated() {
        $sessionId = $_COOKIE['admin_session'] ?? null;
        
        if (!$sessionId) {
            return false;
        }
        
        $sql = "SELECT s.*, u.username, u.full_name, u.role 
                FROM admin_sessions s 
                JOIN admin_users u ON s.admin_id = u.id 
                WHERE s.id = :session_id AND s.expires_at > NOW() AND u.is_active = 1";
        
        $session = $this->db->fetch($sql, ['session_id' => $sessionId]);
        
        if (!$session) {
            $this->logout();
            return false;
        }
        
        // Update session activity
        $this->updateSessionActivity($sessionId);
        
        return $session;
    }
    
    /**
     * Update session activity
     */
    private function updateSessionActivity($sessionId) {
        $sql = "UPDATE admin_sessions SET last_activity = NOW() WHERE id = :session_id";
        $this->db->query($sql, ['session_id' => $sessionId]);
    }
    
    /**
     * Logout user
     */
    public function logout() {
        $sessionId = $_COOKIE['admin_session'] ?? null;
        
        if ($sessionId) {
            $sql = "DELETE FROM admin_sessions WHERE id = :session_id";
            $this->db->query($sql, ['session_id' => $sessionId]);
        }
        
        setcookie('admin_session', '', time() - 3600, '/admin/', '', true, true);
    }
    
    /**
     * Require authentication
     */
    public function requireAuth() {
        $user = $this->isAuthenticated();
        if (!$user) {
            header('Location: /admin/login.php');
            exit;
        }
        return $user;
    }
    
    /**
     * Check user permission
     */
    public function hasPermission($requiredRole = 'admin') {
        $user = $this->isAuthenticated();
        if (!$user) return false;
        
        $roles = ['editor', 'admin', 'super_admin'];
        $userRoleIndex = array_search($user['role'], $roles);
        $requiredRoleIndex = array_search($requiredRole, $roles);
        
        return $userRoleIndex >= $requiredRoleIndex;
    }
}

?>