<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo TITLE_POSTFIX; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="<?php echo ASSETS_PATH; ?>admin/images/fevicon.png" type="image/x-icon">
    <base href="<?php echo ADMIN_URL; ?>/">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .admin-header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .admin-header h2 {
            color: #1E3A8A;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .admin-header .text-muted {
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1E3A8A, #3B82F6);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3B82F6, #1E3A8A);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
        }

        .btn-outline-primary {
            border-color: #3B82F6;
            color: #3B82F6;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #3B82F6;
            border-color: #3B82F6;
            transform: translateY(-1px);
        }

        .form-control:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table thead {
            background: linear-gradient(135deg, #1E3A8A, #3B82F6);
            color: white;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .badge {
            font-size: 0.8em;
            padding: 0.5em 0.8em;
            border-radius: 6px;
        }

        /* Admin Dashboard Specific Styles */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1E3A8A;
            margin-bottom: 5px;
        }

        .recent-activity {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #f1f3f5;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        /* Mobile toggle button */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: #1E3A8A;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }

            .stat-card {
                margin-bottom: 1rem;
            }

            .admin-header {
                padding: 15px 20px;
                margin-bottom: 20px;
            }

            .recent-activity {
                padding: 15px;
            }

            .activity-item {
                padding: 10px 0;
                border-bottom: 1px solid #eee;
            }
        }

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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
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

                                <div class="alert alert-danger" style="display: none">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <div class="msg"></div>
                                </div>

                                <form action="auth" name="loginForm" id="loginForm">
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control" name="email" placeholder="Email"
                                                value="" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Password" value="" required>
                                        </div>
                                    </div>

                                    <div class="d-grid mb-4">
                                        <button type="submit" class="btn btn-login btn-lg">
                                            <i class="fas fa-sign-in-alt me-2"></i>
                                            Sign In
                                        </button>
                                    </div>
                                </form>

                                <!-- <div class="text-center">
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
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ASSETS_PATH; ?>admin/js/login.js?rand=" . RAND></script>
</body>

</html>