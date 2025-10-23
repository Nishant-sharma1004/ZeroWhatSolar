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
                <h1 class="page-title-heading">Services</h1>
            </div>
        </div>

        <section class="section-padding">
            <div class="container">
                <h2 class="section-title">
                    <?php echo $settings['services_title'] ?? 'Complete Solar Solutions for Every Need'; ?>
                </h2>
                <p class="section-subtitle">
                    <?php echo $settings['services_subtitle'] ?? 'From residential rooftops to large industrial installations, we provide end-to-end solar solutions with guaranteed performance and maximum savings.'; ?>
                </p>
                <div class="row g-4 mb-5">
                    <?php if (!empty($services)): ?>
                        <?php
                        $mainServices = array_filter($services, function ($service) {
                            return $service['service_type'] === 'main';
                        });
                        ?>
                        <?php foreach ($mainServices as $service): ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="service-card">
                                    <div class="icon"><i
                                            class="<?php echo $service['icon'] ?? 'fas fa-solar-panel'; ?>"></i>
                                    </div>
                                    <h4><?php echo $service['service_name']; ?></h4>
                                    <p class="mb-3"><?php echo $service['description']; ?></p>
                                    <?php if (!empty($service['features'])): ?>
                                        <ul class="list-unstyled text-start">
                                            <?php
                                            $features = json_decode($service['features'], true);
                                            if (is_array($features)):
                                                foreach ($features as $feature):
                                                    ?>
                                                    <li>✓ <?php echo $feature; ?></li>
                                                <?php endforeach; endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <div class="mt-3">
                                        <?php if (!empty($service['price_display'])): ?>
                                            <span
                                                class="badge bg-<?php echo $service['price_type'] === 'starting' ? 'success' : ($service['price_type'] === 'custom' ? 'warning text-dark' : 'primary'); ?>">
                                                <?php echo $service['price_display']; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback content if no services in database -->
                        <div class="col-lg-4 col-md-6">
                            <div class="service-card">
                                <div class="icon"><i class="fas fa-home"></i></div>
                                <h4>Residential Solar Systems</h4>
                                <p class="mb-3">Transform your home into a power station with our premium residential solar
                                    solutions.</p>
                                <div class="mt-3">
                                    <span class="badge bg-success">Starting from ₹55,000</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="service-card">
                                <div class="icon"><i class="fas fa-building"></i></div>
                                <h4>Commercial Solar Installation</h4>
                                <p class="mb-3">Reduce operational costs dramatically with commercial solar solutions.</p>
                                <div class="mt-3">
                                    <span class="badge bg-warning text-dark">Custom Pricing</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="service-card">
                                <div class="icon"><i class="fas fa-industry"></i></div>
                                <h4>Industrial Solar Plants</h4>
                                <p class="mb-3">Large-scale solar installations for manufacturing units and industrial
                                    complexes.</p>
                                <div class="mt-3">
                                    <span class="badge bg-primary">Contact for Quote</span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Additional Services -->
                <h3 class="text-center mb-4 text-primary">
                    <?php echo $settings['additional_services_title'] ?? 'Additional Services'; ?>
                </h3>
                <div class="row g-4">
                    <?php
                    $additionalServices = array_filter($services, function ($service) {
                        return $service['service_type'] === 'additional';
                    });
                    ?>
                    <?php if (!empty($additionalServices)): ?>
                        <?php foreach ($additionalServices as $service): ?>
                            <div class="col-lg-3 col-md-6">
                                <div class="service-card h-100">
                                    <div class="icon"><i
                                            class="<?php echo $service['icon'] ?? 'fas fa-cog'; ?>"></i></div>
                                    <h5><?php echo $service['service_name']; ?></h5>
                                    <p><?php echo $service['description']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback additional services -->
                        <div class="col-lg-3 col-md-6">
                            <div class="service-card h-100">
                                <div class="icon"><i class="fas fa-tools"></i></div>
                                <h5>Maintenance & AMC</h5>
                                <p>Regular cleaning, health checks, and performance monitoring to ensure optimal output.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="service-card h-100">
                                <div class="icon"><i class="fas fa-file-alt"></i></div>
                                <h5>Subsidy Processing</h5>
                                <p>Complete documentation and government subsidy claim processing with guaranteed approval.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="service-card h-100">
                                <div class="icon"><i class="fas fa-chart-line"></i></div>
                                <h5>Energy Monitoring</h5>
                                <p>Real-time performance tracking with mobile app and detailed analytics reporting.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="service-card h-100">
                                <div class="icon"><i class="fas fa-handshake"></i></div>
                                <h5>Financing Solutions</h5>
                                <p>Zero down payment options, easy EMIs, and flexible financing to make solar affordable.
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Service Inquiry Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow border-0">
                            <div class="card-body p-4">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold text-primary">Interested in Our Services?</h3>
                                    <p class="text-muted">Get personalized recommendations and pricing for your solar
                                        project</p>
                                </div>

                                <form action="process-form" method="POST" id="InquiryForm">
                                    <input type="hidden" name="source" value="services_inquiry">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="serviceName" class="form-label">Full Name *</label>
                                            <input type="text" class="form-control" id="serviceName" name="name"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="servicePhone" class="form-label">Phone Number *</label>
                                            <input type="tel" class="form-control" id="servicePhone" name="phone"
                                                pattern="[0-9]{10}" placeholder="10-digit mobile number" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="serviceEmail" class="form-label">Email Address *</label>
                                            <input type="email" class="form-control" id="serviceEmail" name="email"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="serviceType" class="form-label">Service of Interest</label>
                                            <select class="form-control" id="serviceType" name="service_type">
                                                <option value="">Select Service</option>
                                                <option value="residential">Residential Solar</option>
                                                <option value="commercial">Commercial Solar</option>
                                                <option value="industrial">Industrial Solar</option>
                                                <option value="maintenance">Maintenance & AMC</option>
                                                <option value="subsidy">Subsidy Processing</option>
                                                <option value="financing">Financing Solutions</option>
                                                <option value="consultation">Free Consultation</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="serviceMessage" class="form-label">Your Requirements</label>
                                            <textarea class="form-control" id="serviceMessage" name="message" rows="3"
                                                placeholder="Tell us about your energy needs, project requirements, or any specific questions about our services..."></textarea>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                                <i class="fas fa-comment-dots me-2"></i>Request Service Information
                                            </button>
                                            <p class="text-muted mt-2 mb-0">
                                                <small><i class="fas fa-clock me-1"></i>Our service specialist will
                                                    contact you within 1 hour</small>
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