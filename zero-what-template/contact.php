<?php 
    $pageTitle = "Contact Us";
    
    // Handle status messages
    $status = $_GET['status'] ?? '';
    $message = $_GET['msg'] ?? '';
    
    include 'partials/header.php'; 
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title-heading"><?php echo $pageTitle; ?></h1>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <h2 class="section-title">Get Your FREE Solar Consultation</h2>
        <p class="section-subtitle">Ready to slash your electricity bills? Our solar experts will design a custom solution for your property and calculate your exact savings potential.</p>
        
        <?php if ($status === 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>🎉 Thank You!</strong> Your inquiry has been submitted successfully. Our solar experts will contact you within 2 hours with a detailed proposal.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php elseif ($status === 'error'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>⚠️ Error:</strong> 
            <?php 
            switch($message) {
                case 'invalid_email': echo 'Please enter a valid email address.'; break;
                case 'missing_fields': echo 'Please fill in all required fields.'; break;
                case 'invalid_phone': echo 'Please enter a valid 10-digit phone number.'; break;
                case 'mail_failed': echo 'Unable to send message. Please try again or call us directly.'; break;
                default: echo 'Something went wrong. Please try again.';
            }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        <div class="row g-5">
            <div class="col-lg-6">
                <h4 class="mb-4 text-primary">📋 Get FREE Detailed Quote</h4>
                <div class="alert alert-info mb-4">
                    <strong>💰 Special Offer:</strong> Get up to ₹78,000 government subsidy + Zero down payment options available!
                </div>
                <form action="process-form.php" method="POST" id="contactForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9]{10}" placeholder="10-digit mobile number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="propertyType" class="form-label">Property Type</label>
                            <select class="form-control" id="propertyType" name="property_type">
                                <option value="">Select Property Type</option>
                                <option value="residential">Residential</option>
                                <option value="commercial">Commercial</option>
                                <option value="industrial">Industrial</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="monthlyBill" class="form-label">Monthly Electricity Bill (₹)</label>
                            <select class="form-control" id="monthlyBill" name="monthly_bill">
                                <option value="">Select Bill Range</option>
                                <option value="1000-2000">₹1,000 - ₹2,000</option>
                                <option value="2000-5000">₹2,000 - ₹5,000</option>
                                <option value="5000-10000">₹5,000 - ₹10,000</option>
                                <option value="10000+">₹10,000+</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address (Jaipur)</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Your area/locality in Jaipur">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Additional Requirements</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Any specific requirements or questions about solar installation..."></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="whatsapp" name="whatsapp_updates">
                        <label class="form-check-label" for="whatsapp">
                            Send me updates and savings tips on WhatsApp
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">🚀 Get My FREE Solar Quote</button>
                    <small class="text-muted mt-2 d-block text-center">Our solar experts will contact you within 2 hours</small>
                </form>
            </div>
            <div class="col-lg-6">
                <h4 class="mb-4 text-primary">🏢 Visit Our Office</h4>
                <div class="contact-info">
                    <div class="mb-4 p-3 bg-light rounded">
                        <strong>📍 Address:</strong><br>
                        Sitapura Industrial Area,<br> 
                        Jaipur, Rajasthan 302022
                    </div>
                    <div class="mb-4 p-3 bg-light rounded">
                        <strong>📞 Phone:</strong><br>
                        <a href="tel:+919876543210" class="btn btn-outline-success btn-sm">📱 +91 987 654 3210</a><br>
                        <small class="text-muted">Call for instant consultation</small>
                    </div>
                    <div class="mb-4 p-3 bg-light rounded">
                        <strong>✉️ Email:</strong><br>
                        <a href="mailto:contact@zerowhatsolar.in">contact@zerowhatsolar.in</a><br>
                        <small class="text-muted">Get detailed quote via email</small>
                    </div>
                    <div class="mb-4 p-3 bg-light rounded">
                        <strong>🕐 Business Hours:</strong><br>
                        Monday - Saturday: 10:00 AM - 6:00 PM<br>
                        Sunday: Closed<br>
                        <small class="text-success">📞 Emergency support available 24/7</small>
                    </div>
                </div>
                <div class="map-responsive mt-4">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d114002.8277330838!2d75.73516388421869!3d26.79383391850116!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396dc9523a7891e5%3A0x83342f4133869269!2sSitapura%20Industrial%20Area%2C%20Sitapura%2C%20Jaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1693828943801!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
    include 'partials/footer.php'; 
?>