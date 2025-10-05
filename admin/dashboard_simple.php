<?php
// Simple admin dashboard for testing
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Zero What Solar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .dashboard-header {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .dashboard-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }
        .stat-card {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #1e3a8a;
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1><i class="fas fa-solar-panel me-3"></i>Zero What Solar Admin</h1>
                    <p class="mb-0">Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?>!</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="logout.php" class="btn btn-light">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Success Message -->
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">🎉 Login Successful!</h4>
            <p>You have successfully logged in to the Zero What Solar admin panel.</p>
            <hr>
            <p class="mb-0">Your session details:</p>
            <ul class="mb-0">
                <li><strong>User ID:</strong> <?php echo htmlspecialchars($_SESSION['admin_id'] ?? 'N/A'); ?></li>
                <li><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'N/A'); ?></li>
                <li><strong>Role:</strong> <?php echo htmlspecialchars($_SESSION['admin_role'] ?? 'N/A'); ?></li>
                <li><strong>Login Time:</strong> <?php echo date('Y-m-d H:i:s', $_SESSION['admin_login_time'] ?? time()); ?></li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Quick Stats -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <div class="stat-number">500+</div>
                    <div class="text-muted">Customers</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <i class="fas fa-solar-panel fa-3x text-success mb-3"></i>
                    <div class="stat-number">1000+</div>
                    <div class="text-muted">kW Installed</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <i class="fas fa-rupee-sign fa-3x text-warning mb-3"></i>
                    <div class="stat-number">₹2Cr+</div>
                    <div class="text-muted">Savings Generated</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <i class="fas fa-star fa-3x text-info mb-3"></i>
                    <div class="stat-number">4.9</div>
                    <div class="text-muted">Customer Rating</div>
                </div>
            </div>
        </div>

        <!-- Admin Menu -->
        <div class="dashboard-card">
            <h3 class="mb-4"><i class="fas fa-tools me-2"></i>Admin Panel Menu</h3>
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <a href="blog-manage.php" class="btn btn-outline-primary w-100 p-3">
                        <i class="fas fa-blog fa-2x d-block mb-2"></i>
                        Manage Blog Posts
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="contacts-manage.php" class="btn btn-outline-primary w-100 p-3">
                        <i class="fas fa-envelope fa-2x d-block mb-2"></i>
                        Contact Submissions
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="testimonials-manage.php" class="btn btn-outline-primary w-100 p-3">
                        <i class="fas fa-star fa-2x d-block mb-2"></i>
                        Manage Testimonials
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="projects-manage.php" class="btn btn-outline-primary w-100 p-3">
                        <i class="fas fa-project-diagram fa-2x d-block mb-2"></i>
                        Project Portfolio
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="pricing-manage.php" class="btn btn-outline-primary w-100 p-3">
                        <i class="fas fa-tags fa-2x d-block mb-2"></i>
                        Pricing Management
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="settings-manage.php" class="btn btn-outline-primary w-100 p-3">
                        <i class="fas fa-cog fa-2x d-block mb-2"></i>
                        Site Settings
                    </a>
                </div>
            </div>
        </div>

        <!-- Website Links -->
        <div class="dashboard-card">
            <h3 class="mb-4"><i class="fas fa-external-link-alt me-2"></i>Website Links</h3>
            <div class="row g-3">
                <div class="col-lg-6">
                    <a href="../index.php" target="_blank" class="btn btn-outline-success w-100">
                        <i class="fas fa-home me-2"></i>View Homepage
                    </a>
                </div>
                <div class="col-lg-6">
                    <a href="../contact.php" target="_blank" class="btn btn-outline-success w-100">
                        <i class="fas fa-phone me-2"></i>View Contact Page
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>