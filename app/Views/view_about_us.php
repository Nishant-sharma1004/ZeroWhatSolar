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
                <h1 class="page-title-heading">About Us</h1>
            </div>
        </div>

        <section class="section-padding">
            <div class="container">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6">
                        <div class="about-image position-relative">
                            <img src="<?php echo ASSETS_PATH; ?>images/images.jpg" class="img-fluid rounded shadow-lg"
                                alt="Our Team at Zero What Solar">
                            <div class="position-absolute top-0 start-0 bg-primary text-white p-3 rounded-end">
                                <h6 class="mb-0"><i class="fas fa-award me-2"></i>Certified Solar Partner</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-content">
                            <h2 class="fw-bold text-primary mb-3">Your Trusted Solar Partner in Jaipur</h2>
                            <p class="lead text-muted">Zero What Solar was founded with a simple mission: to make clean,
                                affordable solar energy accessible to every home and business in Rajasthan.</p>
                            <p>We are a team of passionate engineers and technicians dedicated to designing and
                                installing high-quality, long-lasting solar power systems. Our commitment to excellence
                                and our deep understanding of the local landscape make us the preferred choice for solar
                                solutions in Jaipur.</p>

                            <div class="row g-4 mt-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-bullseye text-primary fs-4 me-3"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold">Our Mission</h6>
                                            <p class="mb-0">To accelerate Rajasthan's transition to sustainable energy
                                                and make solar power accessible to every household and business.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-eye text-primary fs-4 me-3"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold">Our Vision</h6>
                                            <p class="mb-0">To be the most trusted and customer-centric solar company in
                                                India, leading the renewable energy revolution.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-heart text-primary fs-4 me-3"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold">Our Values</h6>
                                            <p class="mb-0">Quality, Integrity, Customer Satisfaction, Innovation, and
                                                Environmental Responsibility.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12 mb-4">
                        <h3 class="fw-bold text-primary">Our Impact in Numbers</h3>
                        <p class="text-muted">Powering Jaipur's sustainable future, one rooftop at a time</p>
                    </div>
                    <?php foreach ($stats as $stat) { ?>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="stat-number h2 text-primary fw-bold">
                                        <?php echo $stat['stat_value']; ?>
                                    </div>
                                    <div class="stat-label text-muted"><?php echo $stat['stat_label']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h3 class="fw-bold text-primary">Why Choose Zero What Solar?</h3>
                        <p class="text-muted">What makes us Jaipur's preferred solar energy partner</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-certificate text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold">Certified Excellence</h5>
                                <p class="text-muted">Government authorized solar partner with all necessary
                                    certifications and licenses for hassle-free installations.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-tools text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold">Expert Installation</h5>
                                <p class="text-muted">Our experienced team ensures perfect installation with minimal
                                    disruption and maximum efficiency.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-shield-alt text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold">25-Year Warranty</h5>
                                <p class="text-muted">Comprehensive warranty coverage and dedicated after-sales support
                                    for complete peace of mind.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-rupee-sign text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold">Best Pricing</h5>
                                <p class="text-muted">Competitive pricing with maximum government subsidy benefits and
                                    flexible financing options.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-clock text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold">Quick Installation</h5>
                                <p class="text-muted">Fast turnaround time from consultation to commissioning, typically
                                    completed within 7-15 days.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="fas fa-headset text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold">24/7 Support</h5>
                                <p class="text-muted">Round-the-clock customer support and maintenance services to keep
                                    your system running optimally.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Customer Testimonial Section -->
        <?php if ($testimonial) { ?>
            <section class="py-5 bg-primary text-white">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <h3 class="fw-bold mb-4">What Our Customers Say</h3>
                            <div class="mb-4">
                                <img src="<?php echo ASSETS_PATH . 'upload_images/testimonials/' . $testimonial->customer_image; ?>"
                                    class="rounded-circle mb-3" width="80" height="80"
                                    alt="<?php echo $testimonial->customer_name; ?>"
                                    style="object-fit: cover; border: 3px solid rgba(255,255,255,0.3);">
                            </div>
                            <blockquote class="blockquote">
                                <p class="lead mb-4">"<?php echo $testimonial->testimonial_text; ?>"</p>
                                <footer class="blockquote-footer">
                                    <strong><?php echo $testimonial->customer_name; ?></strong>
                                    <?php if (isset($testimonial->client_designation) && $testimonial->client_designation) { ?>
                                        <br><small><?php echo $testimonial->client_designation; ?></small>
                                    <?php } ?>
                                    <?php if (isset($testimonial->client_company) && $testimonial->client_company) { ?>
                                        <br><small><?php echo $testimonial->client_company; ?></small>
                                    <?php } ?>
                                </footer>
                            </blockquote>
                            <div class="text-center mt-3">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <i
                                        class="fas fa-star<?php echo ($i <= $testimonial->rating ? '' : '-o'); ?> text-warning"></i>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>

        <!-- Quick Inquiry Section -->
        <section class="section-padding bg-light">
            <div class="container">
                <div class="alert  alert-dismissible fade show" role="alert" style="display: none;">
                    <div class="msg"></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-lg border-0">
                            <div class="card-body p-5">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold text-primary">Ready to Go Solar?</h3>
                                    <p class="text-muted">Get a quick consultation with our solar experts. We'll help
                                        you understand the best solar solution for your needs.</p>
                                </div>

                                <form action="process-form" method="POST" id="InquiryForm">
                                    <input type="hidden" name="source" value="about_us_inquiry">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="aboutName" class="form-label">Full Name *</label>
                                            <input type="text" class="form-control" id="aboutName" name="name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="aboutPhone" class="form-label">Phone Number *</label>
                                            <input type="tel" class="form-control phone" id="aboutPhone" name="phone"
                                                placeholder="10-digit mobile number" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="aboutEmail" class="form-label">Email Address *</label>
                                            <input type="email" class="form-control" id="aboutEmail" name="email"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="aboutPropertyType" class="form-label">Property Type</label>
                                            <select class="form-control" id="aboutPropertyType" name="property_type">
                                                <option value="">Select Property Type</option>
                                                <option value="residential">Residential</option>
                                                <option value="commercial">Commercial</option>
                                                <option value="industrial">Industrial</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="aboutMessage" class="form-label">Your Requirements</label>
                                            <textarea class="form-control" id="aboutMessage" name="message" rows="3"
                                                placeholder="Tell us about your energy needs, roof space, current electricity bill, or any specific questions..."></textarea>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                                <i class="fas fa-paper-plane me-2"></i>Send Inquiry
                                            </button>
                                            <p class="text-muted mt-2 mb-0">
                                                <small><i class="fas fa-shield-alt me-1"></i>Your information is secure.
                                                    Our expert will contact you within 2 hours.</small>
                                            </p>
                                        </div>
                                    </div>
                                </form>
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