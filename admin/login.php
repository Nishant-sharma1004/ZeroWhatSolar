<?php
/**
 * Admin Login Page - Zero What Solar CMS
 * Fixed version to resolve syntax errors
 */

require_once '../config/database.php';

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$success = '';

// Handle logout message
if (isset($_GET['logged_out'])) {
    $success = 'You have been logged out successfully.';
}

if (isset($_GET['timeout'])) {
    $error = 'Your session has expired. Please login again.';
}

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard_simple.php');
    exit;
}

// Handle login form submission
if ($_POST) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        try {
            $db = Database::getInstance();
            
            // Check if user exists and is active
            $sql = "SELECT id, username, email, password_hash, full_name, role, is_active 
                    FROM admin_users 
                    WHERE (username = :username OR email = :username) AND is_active = 1";
            
            $user = $db->fetch($sql, ['username' => $username]);
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // Login successful
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_role'] = $user['role'];
                $_SESSION['admin_login_time'] = time();
                
                // Update last login (SQLite compatible)
                try {
                    $updateSql = "UPDATE admin_users SET last_login = datetime('now') WHERE id = ?";
                    $db->query($updateSql, [$user['id']]);
                } catch (Exception $e) {
                    // Log but don't fail login for this
                    error_log("Last login update failed: " . $e->getMessage());
                }
                
                // Successful login - redirect to dashboard
                header('Location: dashboard_simple.php');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
            
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $error = 'Database connection error. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Zero What Solar</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-blue: #1E3A8A;
            --accent-blue: #3B82F6;
            --gradient-blue: #1D4ED8;
            --gradient-light: #60A5FA;
        }
        
        body {
            background: linear-gradient(135deg, var(--gradient-blue), var(--gradient-light));
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        
        .login-left {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
        
        .login-right {
            padding: 3rem;
        }
        
        .logo {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
            border: none;
            border-radius: 10px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
            color: white;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .input-group-text {
            background: transparent;
            border: 2px solid #e5e7eb;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .input-group:focus-within .input-group-text {
            border-color: var(--accent-blue);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="login-card">
                        <div class="row g-0">
                            <!-- Left Side - Branding -->
                            <div class="col-lg-6 login-left d-none d-lg-flex">
                                <div>
                                    <div class="logo">
                                        <i class="fas fa-solar-panel"></i>
                                        Zero What Solar
                                    </div>
                                    <h3 class="mb-3">Admin Dashboard</h3>
                                    <p class="lead">Manage your solar business with our comprehensive CMS platform.</p>
                                    <div class="mt-4">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="h4 mb-1">500+</div>
                                                <small>Customers</small>
                                            </div>
                                            <div class="col-4">
                                                <div class="h4 mb-1">1000+</div>
                                                <small>kW Installed</small>
                                            </div>
                                            <div class="col-4">
                                                <div class="h4 mb-1">₹2Cr+</div>
                                                <small>Savings</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Side - Login Form -->
                            <div class="col-lg-6 login-right">
                                <div class="text-center mb-4">
                                    <h2 class="h3 text-primary">
                                        <i class="fas fa-lock"></i>
                                        Admin Login
                                    </h2>
                                    <p class="text-muted">Sign in to access your dashboard</p>
                                </div>
                                
                                <?php if ($error): ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <?php echo htmlspecialchars($error); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($success): ?>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i>
                                        <?php echo htmlspecialchars($success); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form method="POST" action="">
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control" name="username" placeholder="Username or Email" value="admin" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" name="password" placeholder="Password" value="admin123" required>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid mb-4">
                                        <button type="submit" class="btn btn-login btn-lg">
                                            <i class="fas fa-sign-in-alt me-2"></i>
                                            Sign In
                                        </button>
                                    </div>
                                </form>
                                
                                <div class="text-center">
                                    <small class="text-muted">
                                        Default credentials: admin / admin123
                                    </small>
                                </div>
                                
                                <div class="text-center mt-3">
                                    <small>
                                        <a href="debug_login.php" class="text-decoration-none">
                                            <i class="fas fa-tools me-1"></i>Debug Login
                                        </a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>