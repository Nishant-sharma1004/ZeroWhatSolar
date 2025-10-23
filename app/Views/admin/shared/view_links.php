<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - <?php echo TITLE_POSTFIX; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<base href="<?php echo ADMIN_URL; ?>">
<link rel="shortcut icon" href="<?php echo ASSETS_PATH; ?>admin/images/fevicon.png" type="image/x-icon">
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

    /* Sidebar Styles */
    :root {
        --primary-blue: #1E3A8A;
        --accent-blue: #3B82F6;
        --gradient-blue: #1D4ED8;
        --gradient-light: #60A5FA;
        --sidebar-width: 250px;
    }

    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: var(--sidebar-width);
        background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
        color: white;
        z-index: 1000;
        overflow-y: auto;
        padding: 0;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .admin-sidebar .sidebar-header {
        padding: 1.5rem 1rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
    }

    .admin-sidebar .sidebar-header h4 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .admin-sidebar .sidebar-header small {
        opacity: 0.8;
        font-size: 0.9rem;
    }

    .admin-sidebar .sidebar-nav {
        padding: 1rem 0;
    }

    .admin-sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px;
        margin: 3px 15px;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        text-decoration: none;
        font-size: 0.95rem;
        border: none;
        background: none;
    }

    .admin-sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        transform: translateX(3px);
    }

    .admin-sidebar .nav-link.active {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-weight: 600;
        border-left: 3px solid white;
        margin-left: 12px;
    }

    .admin-sidebar .nav-link i {
        width: 20px;
        margin-right: 10px;
        text-align: center;
    }

    .admin-sidebar .nav-divider {
        border-color: rgba(255, 255, 255, 0.2);
        margin: 15px 0;
    }

    .admin-sidebar .nav-section {
        margin-top: 20px;
    }

    .admin-sidebar .nav-link.text-warning:hover {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }

    .admin-sidebar .nav-link.text-success:hover {
        background: rgba(25, 135, 84, 0.2);
        color: #198754;
    }

    /* Main content adjustment */
    .main-content {
        margin-left: var(--sidebar-width);
        padding: 2rem;
        min-height: 100vh;
        background-color: #f8fafc;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .admin-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .admin-sidebar.show {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
            padding: 1rem;
        }

        .mobile-toggle {
            display: block !important;
        }
    }

    /* Mobile toggle overlay */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    @media (max-width: 768px) {
        .sidebar-overlay.show {
            display: block;
        }
    }
</style>