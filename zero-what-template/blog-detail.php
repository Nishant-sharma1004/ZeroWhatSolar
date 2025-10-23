<?php 
    $pageTitle = "Blog Post"; 
    
    // Simple blog post data (in a real application, this would come from a database)
    $blogPosts = [
        1 => [
            'title' => 'Complete Guide to Solar Panel Installation in Jaipur 2024',
            'content' => '
                <p class="lead">Installing solar panels in Jaipur has never been more accessible, thanks to government initiatives and decreasing costs. This comprehensive guide covers everything you need to know about going solar in the Pink City.</p>
                
                <h3>Why Choose Solar in Jaipur?</h3>
                <p>Jaipur receives excellent solar irradiation throughout the year, making it one of the best cities in India for solar energy generation. With over 300 sunny days annually, your solar investment will pay off faster than in most other cities.</p>
                
                <img src="assets/images/download.jpg" class="img-fluid rounded my-4" alt="Solar Installation Process">
                
                <h3>Step-by-Step Installation Process</h3>
                <ol>
                    <li><strong>Site Assessment:</strong> Our experts visit your location to assess roof condition, shading, and electrical infrastructure.</li>
                    <li><strong>System Design:</strong> We create a customized solar system design based on your energy consumption and roof space.</li>
                    <li><strong>Permits & Approvals:</strong> We handle all government approvals and net metering applications.</li>
                    <li><strong>Installation:</strong> Professional installation typically takes 1-2 days for residential systems.</li>
                    <li><strong>Commissioning:</strong> System testing and grid connection to start generating clean energy.</li>
                </ol>
                
                <div class="alert alert-info">
                    <h5>💡 Pro Tip</h5>
                    <p class="mb-0">The best time to install solar panels in Jaipur is during the post-monsoon period (October to February) for optimal installation conditions.</p>
                </div>
                
                <h3>Cost Breakdown and Government Benefits</h3>
                <p>The cost of solar installation in Jaipur varies based on system size and component quality. Here\'s what you can expect:</p>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>System Size</th>
                            <th>Cost (Before Subsidy)</th>
                            <th>Government Subsidy</th>
                            <th>Final Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>3 kW</td>
                            <td>₹1,95,000</td>
                            <td>₹54,000</td>
                            <td>₹1,41,000</td>
                        </tr>
                        <tr>
                            <td>5 kW</td>
                            <td>₹3,25,000</td>
                            <td>₹78,000</td>
                            <td>₹2,47,000</td>
                        </tr>
                        <tr>
                            <td>10 kW</td>
                            <td>₹6,50,000</td>
                            <td>₹78,000</td>
                            <td>₹5,72,000</td>
                        </tr>
                    </tbody>
                </table>
                
                <h3>Maintenance and Performance</h3>
                <p>Solar panels require minimal maintenance in Jaipur\'s climate. Regular cleaning during dust storm seasons and annual professional inspections ensure optimal performance for 25+ years.</p>
                
                <blockquote class="blockquote text-center my-4">
                    <p class="mb-0">"Our 5kW solar system has reduced our electricity bill from ₹4,500 to just ₹600 per month. Best investment we\'ve made!"</p>
                    <footer class="blockquote-footer mt-2">Rajesh Sharma, <cite title="Source Title">Malviya Nagar</cite></footer>
                </blockquote>
                
                <h3>Next Steps</h3>
                <p>Ready to start your solar journey? Contact our team for a free consultation and personalized quote. We\'ll assess your property and provide detailed savings calculations specific to your energy usage.</p>
            ',
            'author' => 'Solar Expert Team',
            'date' => 'January 15, 2024',
            'category' => 'Installation Guide',
            'image' => 'assets/images/download (1).jpg'
        ],
        2 => [
            'title' => 'How to Get ₹78,000 Solar Subsidy in Rajasthan',
            'content' => '
                <p class="lead">The Government of India offers substantial subsidies for rooftop solar installations. Here\'s your complete guide to claiming up to ₹78,000 in solar subsidies in Rajasthan.</p>
                
                <h3>Eligibility Criteria</h3>
                <ul>
                    <li>Residential consumers of JVVNL, AVVNL, or JdVVNL</li>
                    <li>Own roof or legal right to install solar panels</li>
                    <li>Adequate roof space without shading</li>
                    <li>Proper electrical infrastructure</li>
                </ul>
                
                <h3>Subsidy Amount Structure</h3>
                <p>The subsidy is provided as per the following structure:</p>
                <ul>
                    <li><strong>First 3 kW:</strong> ₹18,000 per kW</li>
                    <li><strong>Beyond 3 kW up to 10 kW:</strong> ₹9,000 per kW</li>
                    <li><strong>Maximum subsidy:</strong> ₹78,000 per household</li>
                </ul>
                
                <div class="alert alert-success">
                    <h5>✅ Important Note</h5>
                    <p class="mb-0">The subsidy is transferred directly to your bank account after successful installation and inspection through DBT (Direct Benefit Transfer).</p>
                </div>
                
                <h3>Required Documents</h3>
                <ol>
                    <li>Electricity bill copy</li>
                    <li>Aadhaar card</li>
                    <li>Bank account details</li>
                    <li>Property ownership documents</li>
                    <li>Passport size photographs</li>
                </ol>
            ',
            'author' => 'Policy Expert',
            'date' => 'January 10, 2024',
            'category' => 'Government Policy',
            'image' => 'assets/images/download (2).jpg'
        ],
        // Add more blog posts as needed
    ];
    
    $postId = isset($_GET['id']) ? intval($_GET['id']) : 1;
    $post = isset($blogPosts[$postId]) ? $blogPosts[$postId] : $blogPosts[1];
    
    $pageTitle = $post['title'];
    include 'partials/header.php'; 
?>

<div class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                <li class="breadcrumb-item"><a href="blog.php" class="text-white">Blog</a></li>
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
                        <div class="badge bg-primary mb-3"><?php echo $post['category']; ?></div>
                        <h1 class="display-5 fw-bold mb-3"><?php echo $post['title']; ?></h1>
                        <div class="post-meta text-muted mb-4">
                            <span><i class="fas fa-calendar me-2"></i><?php echo $post['date']; ?></span>
                            <span class="ms-4"><i class="fas fa-user me-2"></i><?php echo $post['author']; ?></span>
                            <span class="ms-4"><i class="fas fa-clock me-2"></i>5 min read</span>
                        </div>
                    </header>

                    <!-- Featured Image -->
                    <div class="post-image mb-4">
                        <img src="<?php echo $post['image']; ?>" class="img-fluid rounded" alt="<?php echo $post['title']; ?>">
                    </div>

                    <!-- Post Content -->
                    <div class="post-content">
                        <?php echo $post['content']; ?>
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
                                <p class="mb-0">Get a personalized quote and expert consultation for your solar installation in Jaipur.</p>
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
                                    <img src="assets/images/download (3).jpg" class="card-img-top" alt="Related article">
                                    <div class="card-body">
                                        <h6 class="card-title"><a href="blog-detail.php?id=3" class="text-decoration-none">5 Essential Solar Panel Maintenance Tips</a></h6>
                                        <small class="text-muted">January 5, 2024</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <img src="assets/images/download (4).jpg" class="card-img-top" alt="Related article">
                                    <div class="card-body">
                                        <h6 class="card-title"><a href="blog-detail.php?id=4" class="text-decoration-none">Solar ROI Calculator: Is Solar Worth It?</a></h6>
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
                                <img src="assets/images/person1.jpg" class="rounded-circle mb-3" width="80" height="80" alt="Author">
                                <h6 class="mb-1"><?php echo $post['author']; ?></h6>
                                <small class="text-muted">Solar Energy Specialist</small>
                                <p class="mt-3 small">Helping Jaipur residents make informed decisions about solar energy with over 5 years of industry experience.</p>
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
                            <li><a href="#" class="text-decoration-none">Solar Installation <span class="badge bg-secondary">12</span></a></li>
                            <li><a href="#" class="text-decoration-none">Government Policies <span class="badge bg-secondary">8</span></a></li>
                            <li><a href="#" class="text-decoration-none">Maintenance Tips <span class="badge bg-secondary">6</span></a></li>
                            <li><a href="#" class="text-decoration-none">Cost Analysis <span class="badge bg-secondary">10</span></a></li>
                            <li><a href="#" class="text-decoration-none">Technology Updates <span class="badge bg-secondary">5</span></a></li>
                        </ul>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="widget mb-4">
                        <div class="card text-white" style="background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));">
                            <div class="card-body">
                                <h5 class="card-title">Solar Newsletter</h5>
                                <p class="card-text small">Get the latest solar energy news, tips, and exclusive offers delivered to your inbox.</p>
                                <form>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" placeholder="Your email address">
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
                                <img src="assets/images/images.jpg" class="popular-post-thumb me-3" alt="Popular post">
                                <div>
                                    <h6><a href="blog-detail.php?id=1" class="text-decoration-none">Complete Installation Guide</a></h6>
                                    <small class="text-muted">15,234 views</small>
                                </div>
                            </div>
                            <div class="popular-post d-flex mb-3">
                                <img src="assets/images/images (2).jpg" class="popular-post-thumb me-3" alt="Popular post">
                                <div>
                                    <h6><a href="blog-detail.php?id=2" class="text-decoration-none">Government Subsidy Guide</a></h6>
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

<?php 
    include 'partials/footer.php'; 
?>