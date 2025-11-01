<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view('admin/shared/view_links'); ?>
</head>

<body>
    <?php echo view('admin/shared/view_sidebar'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Admin Dashboard</h2>
            <div class="text-muted">
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
                            <div class="stat-number"><?php echo $leadCount; ?></div>
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
                                        <strong><?php echo $contact->name ?? 'Unknown'; ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo $contact->email ?? ''; ?></small>
                                        <br>
                                        <?php if (isset($contact->message) && !empty($contact->message)) { ?>
                                            <small><?php echo substr($contact->message ?? '', 0, 200); ?>...</small>
                                        <?php } ?>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo formatDate($contact->created_at, 'M j, Y g:i A'); ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="text-center mt-3">
                        <a href="<?php echo ADMIN_URL . 'contact-leads'; ?>" class="btn btn-primary">
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
                        <a href="<?php echo ADMIN_URL . 'add-blog-post'; ?>" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add New Blog Post
                        </a>
                        <a href="<?php echo ADMIN_URL . 'add-project'; ?>" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add New Project
                        </a>
                        <a href="<?php echo ADMIN_URL . 'add-testimonials'; ?>" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Add Testimonial
                        </a>
                        <a href="<?php echo ADMIN_URL . 'pricing-packages'; ?>" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>Update Pricing
                        </a>
                        <a href="<?php echo ADMIN_URL . 'site-settings'; ?>" class="btn btn-outline-primary">
                            <i class="fas fa-cog me-2"></i>Site Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo view('admin/shared/view_scripts'); ?>
</body>

</html>