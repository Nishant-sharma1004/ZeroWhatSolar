<!-- Sidebar -->
<div class="admin-sidebar">
    <div class="sidebar-header">
        <i class="fas fa-solar-panel fa-2x mb-2"></i>
        <h4 class="text-white">Zero What Solar</h4>
        <small>Admin Panel</small>
    </div>

    <nav class="sidebar-nav">
        <?php foreach ($header_menus as $key => $value) { ?>
            <a href="<?php echo $value['url']; ?>"
                class="nav-link <?php echo $activeMenu == $value['active'] ? 'active' : ''; ?>">
                <i class="<?php echo $value['icon']; ?>"></i><?php echo $value['name']; ?>
            </a>
        <?php } ?>

        <hr class="nav-divider">

        <div class="nav-section">
            <a href="<?php echo base_url(); ?>" class="nav-link text-success" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Website
            </a>

            <a href="<?php echo ADMIN_URL . 'logout'; ?>" class="nav-link text-warning">
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