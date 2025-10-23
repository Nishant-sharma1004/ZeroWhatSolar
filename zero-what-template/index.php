<?php 
    $pageTitle = "Home";
    
    // Include database configuration
    require_once 'config/database.php';
    
    // Fetch dynamic content from database
    try {
        $db = Database::getInstance();
        
        // Get statistics
        $statsQuery = "SELECT stat_name, stat_value, stat_label FROM site_statistics WHERE is_active = 1 ORDER BY display_order";
        $stats = $db->fetchAll($statsQuery);
        
        // Get hero section content
        $heroQuery = "SELECT * FROM hero_section WHERE is_active = 1 LIMIT 1";
        $heroContent = $db->fetch($heroQuery);
        
        // Get featured testimonials for homepage
        $testimonialsQuery = "SELECT * FROM testimonials WHERE status = 'approved' AND featured = 1 ORDER BY created_at DESC LIMIT 3";
        $testimonials = $db->fetchAll($testimonialsQuery);
        
        // Add fallback images to testimonials that don't have them
        $personImages = ['assets/images/person1.jpg', 'assets/images/person2.jpg', 'assets/images/Person3.jpg'];
        foreach ($testimonials as $index => &$testimonial) {
            if (empty($testimonial['customer_image'])) {
                $testimonial['customer_image'] = $personImages[$index % count($personImages)];
            }
        }
        
        // Get site settings for hero section
        $settingsQuery = "SELECT setting_name, setting_value FROM site_settings WHERE setting_name IN ('company_name', 'company_tagline', 'hero_title', 'hero_description')";
        $settingsResult = $db->fetchAll($settingsQuery);
        $settings = [];
        foreach ($settingsResult as $setting) {
            $settings[$setting['setting_name']] = $setting['setting_value'];
        }
        
    } catch (Exception $e) {
        // Fallback to default values if database fails
        $stats = [
            ['stat_name' => 'customers', 'stat_value' => '500+', 'stat_label' => 'Happy Customers'],
            ['stat_name' => 'installations', 'stat_value' => '1000+', 'stat_label' => 'kW Installed'],
            ['stat_name' => 'savings', 'stat_value' => '₹2Cr+', 'stat_label' => 'Savings Generated'],
            ['stat_name' => 'experience', 'stat_value' => '5+', 'stat_label' => 'Years Experience']
        ];
        $heroContent = null;
        $testimonials = [];
        $settings = [
            'company_name' => 'Zero What Solar',
            'company_tagline' => 'Powering A Brighter Future',
            'hero_title' => "Jaipur's #1 Solar Energy Partner",
            'hero_description' => "Transform your home with premium solar solutions. Join 500+ satisfied customers who've reduced their electricity bills by up to 90% with government-approved solar installations."
        ];
    }
    
    include 'partials/header.php';
?> 
?>

<section class="hero-section" style="background-image: linear-gradient(135deg, rgba(30, 58, 138, 0.85), rgba(59, 130, 246, 0.85)), url('assets/images/hero-bg.jpg');">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="brand-tagline"><?php echo htmlspecialchars($settings['company_tagline'] ?? 'Powering A Brighter Future'); ?></div>
        <h1 class="display-3 fw-bold"><?php echo htmlspecialchars($settings['hero_title'] ?? "Jaipur's #1 Solar Energy Partner"); ?></h1>
        <p class="lead my-4"><?php echo htmlspecialchars($settings['hero_description'] ?? "Transform your home with premium solar solutions. Join 500+ satisfied customers who've reduced their electricity bills by up to 90% with government-approved solar installations."); ?></p>
        <div class="gov-affiliation-badge mb-4">
            🏛️ <strong>Government of India</strong> Authorized Partner | <strong>₹78,000</strong> Subsidy Available
        </div>
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a href="#calculator" class="btn btn-primary btn-lg px-4 py-3">📊 Calculate Your Savings</a>
            <a href="contact.php" class="btn btn-outline-light btn-lg px-4 py-3">📞 Get Free Quote</a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section section-padding">
    <div class="container">
        <div class="row g-4">
            <?php 
            foreach ($stats as $index => $stat): 
                $colClass = count($stats) == 3 ? 'col-lg-4 col-md-4 col-6' : 'col-md-3 col-6';
            ?>
            <div class="<?php echo $colClass; ?>">
                <div class="stat-item">
                    <span class="stat-number"><?php echo htmlspecialchars($stat['stat_value']); ?></span>
                    <span class="stat-label"><?php echo htmlspecialchars($stat['stat_label']); ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="why-choose-section section-padding">
    <div class="container">
        <h2 class="section-title">Why Choose Zero What Solar?</h2>
        <p class="section-subtitle">Join hundreds of satisfied customers in Jaipur who trust us for premium solar solutions with unmatched service and government-backed guarantees.</p>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-certificate"></i></div>
                    <h4>Government Certified</h4>
                    <p>Official partner of India's Rooftop Solar Programme. All installations meet government standards with assured subsidy processing.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-solar-panel"></i></div>
                    <h4>Premium Quality</h4>
                    <p>High-efficiency Tier-1 solar panels with 25-year warranty. Only the best components for maximum energy production and durability.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-users-cog"></i></div>
                    <h4>Expert Local Team</h4>
                    <p>Professional installation by certified engineers. Lifetime support and maintenance with 5-year comprehensive warranty.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                    <h4>Zero Investment Option</h4>
                    <p>Go solar with ₹0 down payment. Government subsidy + EMI options make solar affordable for every household.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-tools"></i></div>
                    <h4>Complete Service</h4>
                    <p>From design to installation to maintenance - we handle everything. One-stop solution for all your solar needs.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                    <h4>Proven Results</h4>
                    <p>90% average bill reduction with 6-8 year payback period. Real savings from day one with 25-year performance guarantee.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Solar Calculator Section -->
<section id="calculator" class="calculator-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="calculator-card">
                    <h2 class="text-center mb-4 text-white">Calculate Your Solar Savings</h2>
                    <p class="text-center mb-4 text-white opacity-75">Get an instant estimate of your potential savings with solar energy</p>
                    <form id="solarCalculator">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-white">Full Name *</label>
                                <input type="text" class="form-control" id="fullNameCalc" placeholder="Your full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white">Phone Number *</label>
                                <input type="tel" class="form-control" id="phoneCalc" placeholder="10-digit mobile number" pattern="[0-9]{10}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white">Monthly Electricity Bill (₹)</label>
                                <input type="number" class="form-control" id="monthlyBill" placeholder="e.g., 3000" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white">Property Type</label>
                                <select class="form-control" id="propertyType" required>
                                    <option value="">Select Property</option>
                                    <option value="residential">Residential</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="industrial">Industrial</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white">Rooftop Area (sq ft)</label>
                                <input type="number" class="form-control" id="rooftopArea" placeholder="e.g., 500">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-white">Email Address *</label>
                                <input type="email" class="form-control" id="emailCalc" placeholder="your@email.com" required>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Get FREE Detailed Report</button>
                            </div>
                        </div>
                    </form>
                    <div id="calculatorResults" class="mt-4" style="display: none;">
                        <!-- Results will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="process-section section-padding">
    <div class="container">
        <h2 class="section-title">How We Make Solar Simple</h2>
        <p class="section-subtitle">From consultation to installation, we handle everything so you can start saving immediately</p>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="process-step">
                    <div class="process-number">1</div>
                    <h4>Free Consultation</h4>
                    <p>Site survey and customized solar design based on your energy needs and roof structure.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="process-step">
                    <div class="process-number">2</div>
                    <h4>Subsidy Processing</h4>
                    <p>We handle all government paperwork and ensure you get the maximum ₹78,000 subsidy benefit.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="process-step">
                    <div class="process-number">3</div>
                    <h4>Professional Installation</h4>
                    <p>Certified engineers install your system in 1-2 days with minimal disruption to your routine.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="process-step">
                    <div class="process-number">4</div>
                    <h4>Start Saving</h4>
                    <p>Begin generating clean energy immediately with 24/7 monitoring and lifetime support.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section section-padding">
    <div class="container">
        <h2 class="section-title">What Our Customers Say</h2>
        <p class="section-subtitle">Don't just take our word for it - hear from real customers who've transformed their energy bills with Zero What Solar</p>
        <div class="row g-4">
            <?php 
            if (!empty($testimonials)): 
                foreach ($testimonials as $testimonial):
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "<?php echo htmlspecialchars($testimonial['testimonial_text']); ?>"
                    </div>
                    <div class="testimonial-author">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo htmlspecialchars($testimonial['customer_image'] ?? 'assets/images/person1.jpg'); ?>" 
                                 class="rounded-circle me-3" width="60" height="60" alt="<?php echo htmlspecialchars($testimonial['customer_name']); ?>" 
                                 style="object-fit: cover;">
                            <div class="author-info">
                                <h5><?php echo htmlspecialchars($testimonial['customer_name']); ?></h5>
                                <small><?php echo htmlspecialchars($testimonial['location']); ?></small>
                            </div>
                        </div>
                        <?php if ($testimonial['rating']): ?>
                        <div class="rating mt-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?php echo $i <= $testimonial['rating'] ? 'filled' : ''; ?>">⭐</span>
                            <?php endfor; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            else:
                // Fallback to static testimonials if none in database
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Zero What Solar reduced my monthly bill from ₹4,500 to just ₹500! The installation was quick and professional. The team handled all the government paperwork for subsidy. Highly recommended!"
                    </div>
                    <div class="testimonial-author">
                        <div class="d-flex align-items-center">
                            <img src="assets/images/person1.jpg" class="rounded-circle me-3" width="60" height="60" alt="Rajesh Sharma" style="object-fit: cover;">
                            <div class="author-info">
                                <h5>Rajesh Sharma</h5>
                                <small>Malviya Nagar, Jaipur</small>
                            </div>
                        </div>
                        <div class="rating mt-2">
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Excellent service from start to finish. My 5kW system generates more power than expected. The subsidy process was smooth and I got ₹78,000 back. Best investment I've made!"
                    </div>
                    <div class="testimonial-author">
                        <div class="d-flex align-items-center">
                            <img src="assets/images/person2.jpg" class="rounded-circle me-3" width="60" height="60" alt="Priya Agarwal" style="object-fit: cover;">
                            <div class="author-info">
                                <h5>Priya Agarwal</h5>
                                <small>Vaishali Nagar, Jaipur</small>
                            </div>
                        </div>
                        <div class="rating mt-2">
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "As an engineer, I was impressed with their technical expertise. Quality installation, premium components, and great after-sales service. My electricity bill is practically zero now!"
                    </div>
                    <div class="testimonial-author">
                        <div class="d-flex align-items-center">
                            <img src="assets/images/Person3.jpg" class="rounded-circle me-3" width="60" height="60" alt="Amit Kumar" style="object-fit: cover;">
                            <div class="author-info">
                                <h5>Amit Kumar</h5>
                                <small>Mansarovar, Jaipur</small>
                            </div>
                        </div>
                        <div class="rating mt-2">
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                            <span class="star filled">⭐</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Blog Preview Section -->
<section class="section-padding" style="background: #f8f9fa;">
    <div class="container">
        <h2 class="section-title">Latest Solar Energy Insights</h2>
        <p class="section-subtitle">Stay updated with the latest solar energy news, tips, and guides from our experts</p>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <article class="card border-0 shadow-sm h-100">
                    <img src="assets/images/download (4).jpg" class="card-img-top" alt="Solar Installation Guide" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <div class="badge bg-primary mb-2">Installation Guide</div>
                        <h5 class="card-title"><a href="blog-detail.php?id=1" class="text-decoration-none">Complete Guide to Solar Panel Installation</a></h5>
                        <p class="card-text">Everything you need to know about installing solar panels in Jaipur - from permits to maintenance.</p>
                        <small class="text-muted"><i class="fas fa-calendar me-1"></i>January 15, 2024</small>
                    </div>
                </article>
            </div>
            <div class="col-lg-4 col-md-6">
                <article class="card border-0 shadow-sm h-100">
                    <img src="assets/images/images (2).jpg" class="card-img-top" alt="Government Subsidy" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <div class="badge bg-success mb-2">Government Policy</div>
                        <h5 class="card-title"><a href="blog-detail.php?id=2" class="text-decoration-none">How to Get ₹78,000 Solar Subsidy</a></h5>
                        <p class="card-text">Step-by-step guide to claim government solar subsidy in Rajasthan with required documents.</p>
                        <small class="text-muted"><i class="fas fa-calendar me-1"></i>January 10, 2024</small>
                    </div>
                </article>
            </div>
            <div class="col-lg-4 col-md-6">
                <article class="card border-0 shadow-sm h-100">
                    <img src="assets/images/images (3).jpg" class="card-img-top" alt="Solar Maintenance" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <div class="badge bg-warning text-dark mb-2">Maintenance</div>
                        <h5 class="card-title"><a href="blog-detail.php?id=3" class="text-decoration-none">5 Essential Solar Panel Maintenance Tips</a></h5>
                        <p class="card-text">Keep your solar panels performing optimally with these maintenance tips for Jaipur's climate.</p>
                        <small class="text-muted"><i class="fas fa-calendar me-1"></i>January 5, 2024</small>
                    </div>
                </article>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="blog.php" class="btn btn-primary btn-lg">View All Articles</a>
        </div>
    </div>
</section>

<section class="cta-section bg-primary text-white text-center section-padding">
    <div class="container">
        <h2 class="fw-bold">Ready to Join 500+ Happy Solar Customers?</h2>
        <p class="lead my-4">Get your FREE solar consultation today and discover how much you can save with Zero What Solar. Our experts will design a custom solution for your home.</p>
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a href="contact.php" class="btn btn-primary btn-lg px-4 py-3">📞 Get FREE Quote Now</a>
            <a href="tel:+919876543210" class="btn btn-outline-light btn-lg px-4 py-3">📱 Call: +91 98765 43210</a>
        </div>
        <div class="text-center mt-4">
            <div class="d-inline-flex align-items-center bg-white bg-opacity-10 rounded-pill px-4 py-2">
                <span class="text-primary me-2">⭐⭐⭐⭐⭐</span>
                <span class="fw-bold">4.9/5 Rating</span>
                <span class="opacity-75 ms-2">| 500+ Reviews</span>
            </div>
        </div>
    </div>
</section>

<?php 
    include 'partials/footer.php'; 
?>