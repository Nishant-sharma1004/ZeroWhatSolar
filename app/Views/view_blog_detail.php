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
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-white">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('blog'); ?>"
                                class="text-white">Blog</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Article</li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section-padding">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <article class="blog-detail">
                            <!-- Post Header -->
                            <header class="mb-4">
                                <div class="badge bg-primary mb-3"><?php echo $post->category_name; ?></div>
                                <h1 class="display-5 fw-bold mb-3"><?php echo $post->title; ?></h1>
                                <div class="post-meta text-muted mb-4">
                                    <span><i class="fas fa-calendar me-2"></i><?php echo formatDate($post->published_at, 'F j, Y'); ?></span>
                                    <span class="ms-4"><i
                                            class="fas fa-user me-2"></i><?php echo $post->author_name; ?></span>
                                    <span class="ms-4"><i class="fas fa-clock me-2"></i>5 min read</span>
                                </div>
                            </header>

                            <!-- Featured Image -->
                            <div class="post-image mb-4">
                                <img src="<?php echo ASSETS_PATH . 'upload_images/blog/' . $post->featured_image; ?>" class="img-fluid rounded"
                                    alt="<?php echo $post->title; ?>">
                            </div>

                            <!-- Post Content -->
                            <div class="post-content">
                                <?php echo $post->content; ?>
                            </div>

                            <!-- Social Share -->
                            <div class="social-share my-5">
                                <h5>Share this article:</h5>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="fab fa-facebook-f"></i> Facebook
                                    </a>
                                    <a href="#" class="btn btn-outline-info btn-sm">
                                        <i class="fab fa-twitter"></i> Twitter
                                    </a>
                                    <a href="#" class="btn btn-outline-success btn-sm">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="fab fa-linkedin"></i> LinkedIn
                                    </a>
                                </div>
                            </div>

                            <!-- CTA Section -->
                            <div class="cta-section bg-light rounded p-4 my-5">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="text-primary mb-2">Ready to Start Your Solar Journey?</h4>
                                        <p class="mb-0">Get a personalized quote and expert consultation for your solar
                                            installation in Jaipur.</p>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <a href="contact.php" class="btn btn-primary btn-lg">Get Free Quote</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Related Articles -->
                            <div class="related-articles mt-5">
                                <h4 class="mb-4">Related Articles</h4>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm">
                                            <img src="<?php echo ASSETS_PATH; ?>images/download (3).jpg"
                                                class="card-img-top" alt="Related article">
                                            <div class="card-body">
                                                <h6 class="card-title"><a href="blog-detail.php?id=3"
                                                        class="text-decoration-none">5 Essential Solar Panel Maintenance
                                                        Tips</a></h6>
                                                <small class="text-muted">January 5, 2024</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm">
                                            <img src="<?php echo ASSETS_PATH; ?>images/download (4).jpg"
                                                class="card-img-top" alt="Related article">
                                            <div class="card-body">
                                                <h6 class="card-title"><a href="blog-detail.php?id=4"
                                                        class="text-decoration-none">Solar ROI Calculator: Is Solar
                                                        Worth It?</a></h6>
                                                <small class="text-muted">December 28, 2023</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="blog-sidebar">
                            <!-- Author Info -->
                            <div class="widget mb-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img src="<?php echo ASSETS_PATH; ?>images/person1.jpg"
                                            class="rounded-circle mb-3" width="80" height="80" alt="Author">
                                        <h6 class="mb-1"><?php echo $post->author_name; ?></h6>
                                        <small class="text-muted">Solar Energy Specialist</small>
                                        <p class="mt-3 small">Helping Jaipur residents make informed decisions about
                                            solar energy with over 5 years of industry experience.</p>
                                    </div>
                                </div>
                            </div>

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

                            <!-- Newsletter Signup -->
                            <div class="widget mb-4">
                                <div class="card text-white"
                                    style="background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));">
                                    <div class="card-body">
                                        <h5 class="card-title">Solar Newsletter</h5>
                                        <p class="card-text small">Get the latest solar energy news, tips, and exclusive
                                            offers delivered to your inbox.</p>
                                        <form>
                                            <div class="mb-3">
                                                <input type="email" class="form-control"
                                                    placeholder="Your email address">
                                            </div>
                                            <button type="submit" class="btn btn-light w-100">Subscribe</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Popular Posts -->
                            <div class="widget mb-4">
                                <h5 class="widget-title">Popular Posts</h5>
                                <div class="popular-posts">
                                    <div class="popular-post d-flex mb-3">
                                        <img src="<?php echo ASSETS_PATH; ?>images/images.jpg"
                                            class="popular-post-thumb me-3" alt="Popular post">
                                        <div>
                                            <h6><a href="blog-detail.php?id=1" class="text-decoration-none">Complete
                                                    Installation Guide</a></h6>
                                            <small class="text-muted">15,234 views</small>
                                        </div>
                                    </div>
                                    <div class="popular-post d-flex mb-3">
                                        <img src="<?php echo ASSETS_PATH; ?>images/images (2).jpg"
                                            class="popular-post-thumb me-3" alt="Popular post">
                                        <div>
                                            <h6><a href="blog-detail.php?id=2" class="text-decoration-none">Government
                                                    Subsidy Guide</a></h6>
                                            <small class="text-muted">12,876 views</small>
                                        </div>
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