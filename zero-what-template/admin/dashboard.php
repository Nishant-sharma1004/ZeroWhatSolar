<?php
require_once 'auth.php';
checkAdminAuth();
require_once '../config/database.php';

// Get dashboard statistics
try {
    $db = Database::getInstance()->getConnection();
    
    // Count total blog posts
    $stmt = $db->query("SELECT COUNT(*) as count FROM blog_posts");
    $blogCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
    
    // Count total projects
    $stmt = $db->query("SELECT COUNT(*) as count FROM projects");
    $projectCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
    
    // Count total testimonials
    $stmt = $db->query("SELECT COUNT(*) as count FROM testimonials");
    $testimonialCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
    
    // Count contact submissions this month
    $stmt = $db->query("SELECT COUNT(*) as count FROM contact_submissions WHERE DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')");
    $monthlyLeads = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;
    
    // Get recent contact submissions
    $stmt = $db->query("SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5");
    $recentContacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $blogCount = $projectCount = $testimonialCount = $monthlyLeads = 0;
    $recentContacts = [];
}
?>
<?php
$page_title = 'Dashboard';
include 'includes/header.php';
?>
    <?php include 'includes/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Admin Dashboard</h2>
            <div class="text-muted">
                Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number"><?php echo $blogCount; ?></div>
                            <div class="text-muted">Blog Posts</div>
                        </div>
                        <i class="fas fa-blog fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number"><?php echo $projectCount; ?></div>
                            <div class="text-muted">Projects</div>
                        </div>
                        <i class="fas fa-project-diagram fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number"><?php echo $testimonialCount; ?></div>
                            <div class="text-muted">Testimonials</div>
                        </div>
                        <i class="fas fa-star fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number"><?php echo $monthlyLeads; ?></div>
                            <div class="text-muted">Monthly Leads</div>
                        </div>
                        <i class="fas fa-envelope fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row">
            <div class="col-lg-8">
                <div class="recent-activity">
                    <h5 class="mb-3">
                        <i class="fas fa-clock me-2"></i>
                        Recent Contact Submissions
                    </h5>
                    
                    <?php if (empty($recentContacts)): ?>
                        <p class="text-muted">No recent contact submissions found.</p>
                    <?php else: ?>
                        <?php foreach ($recentContacts as $contact): ?>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong><?php echo htmlspecialchars($contact['name'] ?? 'Unknown'); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars($contact['email'] ?? ''); ?></small>
                                        <br>
                                        <small><?php echo htmlspecialchars(substr($contact['message'] ?? '', 0, 100)); ?>...</small>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo date('M j, Y g:i A', strtotime($contact['created_at'] ?? 'now')); ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <div class="text-center mt-3">
                        <a href="contacts-manage.php" class="btn btn-primary">
                            View All Contacts
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="recent-activity">
                    <h5 class="mb-3">
                        <i class="fas fa-tools me-2"></i>
                        Quick Actions
                    </h5>
                    
                    <div class="d-grid gap-2">
                        <a href="blog-manage.php?action=add" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add New Blog Post
                        </a>
                        <a href="projects-manage.php?action=add" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add New Project
                        </a>
                        <a href="testimonials-manage.php?action=add" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add Testimonial
                        </a>
                        <a href="pricing-manage.php" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Update Pricing
                        </a>
                        <a href="settings-manage.php" class="btn btn-outline-primary">
                            <i class="fas fa-cog me-2"></i>Site Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>