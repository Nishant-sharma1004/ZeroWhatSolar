<?php
// Get current page to highlight active navigation
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
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
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }
    
    .admin-sidebar .sidebar-header {
        padding: 1.5rem 1rem;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.05);
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
        border-color: rgba(255,255,255,0.2);
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
        background: rgba(0,0,0,0.5);
        z-index: 999;
        display: none;
    }
    
    @media (max-width: 768px) {
        .sidebar-overlay.show {
            display: block;
        }
    }
</style>

<!-- Sidebar -->
<div class="admin-sidebar">
    <div class="sidebar-header">
        <i class="fas fa-solar-panel fa-2x mb-2"></i>
        <h4 class="text-white">Zero What Solar</h4>
        <small>Admin Panel</small>
    </div>
    
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        
        <a href="blog-manage.php" class="nav-link <?php echo ($current_page == 'blog-manage.php') ? 'active' : ''; ?>">
            <i class="fas fa-blog"></i> Blog Posts
        </a>
        
        <a href="projects-manage.php" class="nav-link <?php echo ($current_page == 'projects-manage.php') ? 'active' : ''; ?>">
            <i class="fas fa-tools"></i> Projects
        </a>
        
        <a href="testimonials-manage.php" class="nav-link <?php echo ($current_page == 'testimonials-manage.php') ? 'active' : ''; ?>">
            <i class="fas fa-star"></i> Testimonials
        </a>
        
        <a href="contacts-manage.php" class="nav-link <?php echo ($current_page == 'contacts-manage.php') ? 'active' : ''; ?>">
            <i class="fas fa-envelope"></i> Contact Leads
        </a>
        
        <a href="pricing-manage.php" class="nav-link <?php echo ($current_page == 'pricing-manage.php') ? 'active' : ''; ?>">
            <i class="fas fa-rupee-sign"></i> Pricing Packages
        </a>
        
        <a href="settings-manage.php" class="nav-link <?php echo ($current_page == 'settings-manage.php') ? 'active' : ''; ?>">
            <i class="fas fa-cog"></i> Site Settings
        </a>
        
        <hr class="nav-divider">
        
        <div class="nav-section">
            <a href="../index.php" class="nav-link text-success" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Website
            </a>
            
            <a href="logout.php" class="nav-link text-warning">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>
</div>

<!-- Mobile overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Mobile toggle button -->
<button class="mobile-toggle" id="mobileToggle" style="display: none;">
    <i class="fas fa-bars"></i>
</button>

<script>
// Mobile sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    function toggleSidebar() {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }
    
    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleSidebar);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
    
    // Close sidebar when clicking on nav links on mobile
    const navLinks = document.querySelectorAll('.admin-sidebar .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                closeSidebar();
            }
        });
    });
});
</script>