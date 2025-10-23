<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ASSETS_PATH; ?>js/jquery-3.7.1.min.js"></script>
<script src="<?php echo ASSETS_PATH . 'js/services.js?rand=' . RAND; ?>"></script>

<script>
    // Mobile sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function () {
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
            link.addEventListener('click', function () {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
    });

    function deletePost(url, title) {
        document.getElementById('deleteUrl').value = url;
        document.getElementById('deleteTitle').textContent = title;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>