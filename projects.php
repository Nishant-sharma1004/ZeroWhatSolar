
<?php
    $pageTitle = "Our Projects";
    
    // Include database configuration
    require_once 'config/database.php';
    
    // Fetch projects from database
    try {
        $db = Database::getInstance();
        
        // Get all published projects
        $projectsQuery = "SELECT p.*, pc.name as category_name 
                         FROM projects p 
                         LEFT JOIN project_categories pc ON p.category_id = pc.id 
                         WHERE p.status = 'completed' 
                         ORDER BY p.featured DESC, p.created_at DESC";
        $projects = $db->fetchAll($projectsQuery);
        
        // Get project statistics
        $statsQuery = "SELECT 
                        COUNT(*) as total_projects,
                        SUM(system_size_kw) as total_kw,
                        ROUND(AVG(CASE WHEN monthly_savings > 0 THEN monthly_savings END)) as avg_savings
                       FROM projects WHERE status = 'completed'";
        $projectStats = $db->fetch($statsQuery);
        
    } catch (Exception $e) {
        // Fallback data if database fails
        $projects = [];
        $projectStats = [
            'total_projects' => 500,
            'total_kw' => 1000,
            'avg_savings' => 8000
        ];
    }
    
    include 'partials/header.php';
?> 
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title-heading"><?php echo $pageTitle; ?></h1>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <h2 class="section-title">Our Solar Success Stories</h2>
        <p class="section-subtitle">Discover how we've helped families and businesses across Jaipur achieve energy independence with our premium solar installations.</p>
        <div class="row g-4">
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="project-item">
                        <?php if ($project['featured_image']): ?>
                        <img src="<?php echo htmlspecialchars($project['featured_image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($project['title']); ?>">
                        <?php else: ?>
                        <img src="assets/images/download.jpg" class="img-fluid" alt="<?php echo htmlspecialchars($project['title']); ?>">
                        <?php endif; ?>
                        <div class="project-overlay">
                            <h5><?php echo htmlspecialchars($project['title']); ?></h5>
                            <p><?php echo htmlspecialchars($project['location']); ?></p>
                            <small class="text-light">
                                System: <?php echo number_format($project['system_size_kw'], 1); ?>kW
                                <?php if ($project['monthly_savings']): ?>
                                | Monthly Savings: ₹<?php echo number_format($project['monthly_savings']); ?>
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback static content if no projects in database -->
                <div class="col-lg-4 col-md-6">
                    <div class="project-item">
                        <img src="assets/images/download (1).jpg" class="img-fluid" alt="5kW Residential Solar Installation">
                        <div class="project-overlay">
                            <h5>5kW Residential Solar</h5>
                            <p>Malviya Nagar, Jaipur</p>
                            <small class="text-light">Monthly Savings: ₹3,800 | ROI: 6 years</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="project-item">
                        <img src="assets/images/download (2).jpg" class="img-fluid" alt="25kW Commercial Solar Installation">
                        <div class="project-overlay">
                            <h5>25kW Commercial Solar</h5>
                            <p>VKI Area, Jaipur</p>
                            <small class="text-light">Monthly Savings: ₹18,500 | ROI: 5 years</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="project-item">
                        <img src="assets/images/download (3).jpg" class="img-fluid" alt="3kW Villa Solar Installation">
                        <div class="project-overlay">
                            <h5>3kW Villa Installation</h5>
                            <p>Vaishali Nagar, Jaipur</p>
                            <small class="text-light">Monthly Savings: ₹2,400 | ROI: 7 years</small>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Customer Impact Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="text-center p-5 bg-light rounded">
                    <h3 class="text-primary mb-4">Real Impact, Real Savings</h3>
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-number text-success">500+</div>
                            <div class="stat-label">Projects Completed</div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-number text-primary">1000+</div>
                            <div class="stat-label">kW Installed</div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-number text-warning">₹2Cr+</div>
                            <div class="stat-label">Customer Savings</div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="stat-number text-success">98%</div>
                            <div class="stat-label">Customer Satisfaction</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
    include 'partials/footer.php'; 
?>