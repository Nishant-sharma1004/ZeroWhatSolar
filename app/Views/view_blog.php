<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view("shared/view_links"); ?>
</head>

<body>
    <?php echo view("shared/view_header"); ?>
    <main>
        <div class="page-header">
            <div class="container">
                <h1 class="page-title-heading">Solar Energy Blog</h1>
                <p class="lead text-white">Expert insights, tips, and latest updates on solar energy in Jaipur</p>
            </div>
        </div>

        <section class="section-padding">
            <div class="container">
                <div class="row">
                    <!-- Main Blog Content -->
                    <div class="col-lg-8">
                        <h2 class="section-title text-start">Latest Articles</h2>

                        <!-- Featured Blog Post -->
                        <?php /*if ($featuredPost) { ?>
<article class="blog-post featured-post mb-5">
<div class="row g-4">
<div class="col-md-6">
<img src="<?php echo $featuredPost['featured_image'] ?: '<?php echo ASSETS_PATH;?>images/download.jpg'; ?>"
class="img-fluid rounded" alt="<?php echo $featuredPost['title']; ?>">
</div>
<div class="col-md-6">
<div class="badge bg-primary mb-2">Featured</div>
<h3><a href="blog-detail.php?slug=<?php echo urlencode($featuredPost['slug']); ?>"
   class="text-decoration-none"><?php echo $featuredPost['title']; ?></a>
</h3>
<p class="text-muted mb-2">
<i
   class="fas fa-calendar me-2"></i><?php echo date('F j, Y', strtotime($featuredPost['created_at'])); ?>
<i class="fas fa-user ms-3 me-2"></i>Solar Expert Team
</p>
<p><?php echo $featuredPost['excerpt'] ?: substr(strip_tags($featuredPost['content']), 0, 150) . '...'; ?>
</p>
<a href="blog-detail.php?slug=<?php echo urlencode($featuredPost['slug']); ?>"
class="btn btn-primary">Read More</a>
</div>
</div>
</article>
<?php } else { ?>
<!-- Fallback static featured post -->
<article class="blog-post featured-post mb-5">
<div class="row g-4">
<div class="col-md-6">
<img src="<?php echo ASSETS_PATH; ?>images/download (1).jpg"
class="img-fluid rounded" alt="Solar Panel Installation Guide">
</div>
<div class="col-md-6">
<div class="badge bg-primary mb-2">Featured</div>
<h3><a href="blog-detail.php?id=1" class="text-decoration-none">Complete Guide to
   Solar Panel Installation in Jaipur 2024</a></h3>
<p class="text-muted mb-2">
<i class="fas fa-calendar me-2"></i>January 15, 2024
<i class="fas fa-user ms-3 me-2"></i>Solar Expert Team
</p>
<p>Everything you need to know about installing solar panels in Jaipur - from
government approvals to cost calculations and maintenance tips.</p>
<a href="blog-detail.php?id=1" class="btn btn-primary">Read More</a>
</div>
</div>
</article>
<?php } */ ?>

                        <!-- Blog Posts Grid -->
                        <div class="row g-4">

                            <?php if (isset($blog_posts) && !empty($blog_posts)) {
                                foreach ($blog_posts as $row) {
                                    if ($row->category_id == 1) {
                                        //Installation Guild
                                        $category_class = 'bg-primary';
                                    } elseif ($row->category_id == 2) {
                                        //Government Policy
                                        $category_class = 'bg-success';
                                    } elseif ($row->category_id == 3) {
                                        //Maintenance
                                        $category_class = 'bg-warning';
                                    } elseif ($row->category_id == 4) {
                                        //Finance
                                        $category_class = 'bg-info';
                                    } elseif ($row->category_id == 5) {
                                        //Technology
                                        $category_class = 'bg-info';
                                    } elseif ($row->category_id == 6) {
                                        //Commercial
                                        $category_class = 'bg-primary';
                                    } ?>
                                    <div class="col-md-6">
                                        <article class="blog-post card h-100 border-0 shadow-sm">
                                            <img src="<?php echo ASSETS_PATH; ?>upload_images/blog/<?php echo $row->featured_image ?>"
                                                class="card-img-top" alt="Government Solar Subsidy">
                                            <div class="card-body">
                                                <div class="badge <?php echo $category_class; ?> mb-2">
                                                    <?php echo $row->category_name; ?>
                                                </div>
                                                <h5 class="card-title"><a
                                                        href="<?php echo base_url('blog-detail/' . $row->url); ?>"
                                                        class="text-decoration-none"><?php echo $row->title; ?></a></h5>
                                                <p class="text-muted small mb-2">
                                                    <i
                                                        class="fas fa-calendar me-2"></i><?php echo formatDate($row->published_at, 'F j, Y'); ?>
                                                </p>
                                                <p class="card-text"><?php echo $row->excerpt; ?></p>
                                                <a href="<?php echo base_url('blog-detail/' . $row->url); ?>"
                                                    class="btn btn-outline-primary btn-sm">Read
                                                    More</a>
                                            </div>
                                        </article>
                                    </div>
                                <?php }
                            } ?>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Blog pagination" class="mt-5">
                            <ul class="pagination justify-content-center">
                                <li class="page-item active">
                                    <a class="page-link" href="#" aria-current="page">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="blog-sidebar">
                            <!-- Search Widget -->
                            <div class="widget mb-4">
                                <h5 class="widget-title">Search Articles</h5>
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search blog posts...">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Categories Widget -->
                            <div class="widget mb-4">
                                <h5 class="widget-title">Categories</h5>
                                <ul class="list-unstyled">
                                    <li><a href="#" class="text-decoration-none">Solar Installation <span
                                                class="badge bg-secondary">12</span></a></li>
                                    <li><a href="#" class="text-decoration-none">Government Policies <span
                                                class="badge bg-secondary">8</span></a></li>
                                    <li><a href="#" class="text-decoration-none">Maintenance Tips <span
                                                class="badge bg-secondary">6</span></a></li>
                                    <li><a href="#" class="text-decoration-none">Cost Analysis <span
                                                class="badge bg-secondary">10</span></a></li>
                                    <li><a href="#" class="text-decoration-none">Technology Updates <span
                                                class="badge bg-secondary">5</span></a></li>
                                </ul>
                            </div>

                            <!-- Recent Posts Widget -->
                            <div class="widget mb-4">
                                <h5 class="widget-title">Recent Posts</h5>
                                <div class="recent-posts">
                                    <div class="recent-post d-flex mb-3">
                                        <img src="<?php echo ASSETS_PATH; ?>images/images (2).jpg"
                                            class="recent-post-thumb me-3" alt="Recent post">
                                        <div>
                                            <h6><a href="#" class="text-decoration-none">Solar Panel Types
                                                    Comparison</a></h6>
                                            <small class="text-muted">January 12, 2024</small>
                                        </div>
                                    </div>
                                    <div class="recent-post d-flex mb-3">
                                        <img src="<?php echo ASSETS_PATH; ?>images/images (3).jpg"
                                            class="recent-post-thumb me-3" alt="Recent post">
                                        <div>
                                            <h6><a href="#" class="text-decoration-none">Net Metering in Rajasthan</a>
                                            </h6>
                                            <small class="text-muted">January 8, 2024</small>
                                        </div>
                                    </div>
                                    <div class="recent-post d-flex mb-3">
                                        <img src="<?php echo ASSETS_PATH; ?>images/download.jpg"
                                            class="recent-post-thumb me-3" alt="Recent post">
                                        <div>
                                            <h6><a href="#" class="text-decoration-none">Solar Battery Backup
                                                    Systems</a></h6>
                                            <small class="text-muted">January 3, 2024</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Widget -->
                            <div class="widget cta-widget">
                                <div class="card text-white"
                                    style="background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Ready to Go Solar?</h5>
                                        <p class="card-text">Get your personalized quote and start saving on electricity
                                            bills today!</p>
                                        <a href="<?php echo base_url('contact'); ?>" class="btn btn-light">Get Free
                                            Quote</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php echo view("shared/view_footer"); ?>
    <?php echo view("shared/view_scripts"); ?>
</body>

</html>