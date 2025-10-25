<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container text-center text-md-start">
        <div class="row">

            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 fw-bold text-warning">Zero What Solar</h5>
                <p>Jaipur's most trusted partner in solar energy solutions. We are an authorized partner of the
                    Government of India's Rooftop Solar Programme, committed to powering Rajasthan's future.</p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 fw-bold text-warning">Quick Links</h5>
                <p><a href="<?php echo base_url('about-us'); ?>" class="text-white text-decoration-none">About Us</a>
                </p>
                <p><a href="<?php echo base_url('services'); ?>" class="text-white text-decoration-none">Services</a>
                </p>
                <p><a href="<?php echo base_url('pricing'); ?>" class="text-white text-decoration-none">Pricing</a></p>
                <p><a href="<?php echo base_url('projects'); ?>" class="text-white text-decoration-none">Our Work</a>
                </p>
                <p><a href="<?php echo base_url('contact'); ?>" class="text-white text-decoration-none">Contact Us</a>
                </p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 fw-bold text-warning">Resources</h5>
                <p><a href="<?php echo base_url('blog'); ?>" class="text-white text-decoration-none">Solar Blog</a></p>
                <p><a href="<?php echo base_url('subsidy-info'); ?>" class="text-white text-decoration-none">Subsidy
                        Info</a></p>
                <p><a href="<?php echo base_url('blog-detail'); ?>?id=1"
                        class="text-white text-decoration-none">Installation Guide</a></p>
                <p><a href="<?php echo base_url('blog-detail'); ?>?id=2"
                        class="text-white text-decoration-none">Government Subsidy</a></p>
                <p><a href="#calculator" class="text-white text-decoration-none">Solar Calculator</a></p>
            </div>

            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 fw-bold text-warning">Contact</h5>
                <p><i class="fas fa-home me-3"></i> Sitapura Industrial Area, Jaipur, Rajasthan 302022</p>
                <p><i class="fas fa-envelope me-3"></i> contact@zerowhatsolar.in</p>
                <p><i class="fas fa-phone me-3"></i> +91 987 654 3210</p>
                <p><i class="fas fa-clock me-3"></i> Mon - Sat, 10:00 AM - 6:00 PM</p>
            </div>
        </div>

        <hr class="my-4">
        <div class="text-center">
            <p>© <?php echo date("Y"); ?> Zero What Solar. All Rights Reserved. Designed with care in Jaipur.</p>
        </div>
    </div>
</footer>

<!-- Popup Quote Form Modal -->
<div class="modal fade" id="popupQuoteModal" tabindex="-1" aria-labelledby="popupQuoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="popupQuoteModalLabel">
                    <i class="fas fa-solar-panel me-2"></i>Get Your FREE Solar Quote in 2 Minutes!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-success border-0">
                            <h6 class="fw-bold">🎆 Limited Time Offer!</h6>
                            <ul class="list-unstyled mb-0">
                                <li>✓ Up to ₹78,000 Government Subsidy</li>
                                <li>✓ Zero Down Payment Options</li>
                                <li>✓ 25-Year Performance Guarantee</li>
                                <li>✓ 90% Electricity Bill Reduction</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form id="popupQuoteForm" action="process-form" method="POST">
                            <input type="hidden" name="source" value="popup_quote">
                            <div class="mb-3">
                                <label for="popupName" class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="popupName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="popupPhone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control phone" id="popupPhone" name="phone" pattern="[0-9]{10}"
                                    placeholder="10-digit mobile number" required>
                            </div>
                            <div class="mb-3">
                                <label for="popupEmail" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="popupEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="popupMonthlyBill" class="form-label">Monthly Electricity Bill (₹)</label>
                                <select class="form-control" id="popupMonthlyBill" name="monthly_bill">
                                    <option value="">Select Bill Range</option>
                                    <option value="1000-2000">₹1,000 - ₹2,000</option>
                                    <option value="2000-5000">₹2,000 - ₹5,000</option>
                                    <option value="5000-10000">₹5,000 - ₹10,000</option>
                                    <option value="10000+">₹10,000+</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-calculator me-2"></i>Get My FREE Quote Now!
                                </button>
                            </div>
                            <small class="text-muted d-block text-center mt-2">
                                🔒 Your information is 100% secure. Our expert will call you within 2 hours.
                            </small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>