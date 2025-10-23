<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">
            <img src="<?php echo ASSETS_PATH; ?>images/logo.png" alt="Zero What Solar Logo" style="height: 50px;">
            <!-- Zero What Solar -->
        </a>
        <!-- Always visible Quote button -->
        <a href="<?php echo base_url('contact') ?>" class="btn btn-success d-block d-lg-none me-2"
            style="font-size: 0.85rem; padding: 8px 12px;">Get Quote</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php foreach ($header_menus as $row) { ?>
                    <li class="nav-item"><a class="nav-link <?php echo $row['active'] == $active_menu ? 'active' : ''; ?>"
                            href="<?php echo $row['url']; ?>"><?php echo $row['name']; ?></a></li>
                <?php } ?>
            </ul>
            <!-- Desktop Quote button -->
            <a href="<?php echo base_url('contact') ?>" class="btn btn-success ms-lg-3 d-none d-lg-block">Get a Free
                Quote</a>
        </div>
    </div>
</nav>