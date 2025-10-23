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
                <h1 class="page-title-heading">Solar Pricing & Packages</h1>
            </div>
        </div>

        <section class="section-padding">
            <div class="container">
                <h2 class="section-title">
                    <?php echo $settings['pricing_title'] ?? 'Personalized Solar Pricing for Every Home'; ?>
                </h2>
                <p class="section-subtitle">
                    <?php echo $settings['pricing_subtitle'] ?? 'Get your personalized quote based on your exact energy needs, roof size, and location in Jaipur.'; ?>
                </p>

                <!-- Dynamic Pricing Calculator -->
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-8">
                        <div class="card shadow-lg border-0"
                            style="background: linear-gradient(135deg, var(--gradient-blue), var(--gradient-light)); color: white;">
                            <div class="card-body p-5">
                                <h3 class="text-center mb-4">Get Your Personalized Quote in 2 Minutes</h3>
                                <p class="text-center mb-4 opacity-75">No generic pricing - each quote is customized for
                                    your specific requirements</p>
                                <form action="process-form" method="POST" id="InquiryForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-white">Full Name *</label>
                                            <input type="text" class="form-control" id="fullNameCalc"
                                                placeholder="Your full name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-white">Phone Number *</label>
                                            <input type="tel" class="form-control" id="phoneCalc"
                                                placeholder="10-digit mobile number" pattern="[0-9]{10}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Property Type *</label>
                                            <select class="form-control" id="propertyTypeDP" required>
                                                <option value="">Select Property Type</option>
                                                <option value="apartment">Apartment/Flat</option>
                                                <option value="independent_house">Independent House</option>
                                                <option value="villa">Villa/Bungalow</option>
                                                <option value="commercial">Commercial Building</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Monthly Electricity Bill (₹) *</label>
                                            <input type="number" class="form-control" id="monthlyBillDP"
                                                placeholder="e.g., 3500" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Rooftop Area (sq ft)</label>
                                            <input type="number" class="form-control" id="rooftopAreaDP"
                                                placeholder="e.g., 800">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Location in Jaipur</label>
                                            <select class="form-control" id="locationDP">
                                                <option value="">Select Area</option>
                                                <option value="malviya_nagar">Malviya Nagar</option>
                                                <option value="vaishali_nagar">Vaishali Nagar</option>
                                                <option value="mansarovar">Mansarovar</option>
                                                <option value="c_scheme">C-Scheme</option>
                                                <option value="bani_park">Bani Park</option>
                                                <option value="sitapura">Sitapura</option>
                                                <option value="sanganer">Sanganer</option>
                                                <option value="other">Other Area</option>
                                            </select>
                                        </div>
                                        <div class="col-12 text-center mt-4">
                                            <button type="submit" class="btn btn-light btn-lg px-5"
                                                style="color: var(--primary-blue); font-weight: 600;">Get My
                                                Personalized Quote</button>
                                        </div>
                                    </div>
                                </form>
                                <div id="dynamicPricingResults" class="mt-4" style="display: none;">
                                    <!-- Dynamic results will be shown here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Why Personalized Pricing? -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="alert alert-primary border-0" style="background: rgba(30, 58, 138, 0.1);">
                            <h4 class="text-primary">💡 Why We Don't Show Fixed Prices</h4>
                            <p class="mb-0">Like Solar Square and other leading solar companies, we believe in
                                transparent, personalized pricing. Your solar system cost depends on your roof size,
                                energy consumption, property type, and location. Our experts analyze these factors to
                                give you the most accurate quote - not a generic estimate.</p>
                        </div>
                    </div>
                </div>

                <!-- Sample Price Ranges for Reference -->
                <h3 class="text-center mb-4 text-primary">📊 Sample Price Ranges for Reference</h3>
                <div class="alert alert-warning text-center mb-5">
                    <strong>Note:</strong> These are indicative ranges only. Your actual quote will be personalized
                    based on your specific requirements.
                </div>
                <div class="row g-4 mb-5">
                    <?php if (!empty($residentialPackages)): ?>
                        <?php foreach ($residentialPackages as $index => $package): ?>
                            <div class="col-lg-4 col-md-6">
                                <div
                                    class="service-card text-center h-100 <?php echo $package['is_popular'] ? 'border-primary' : ''; ?>">
                                    <?php if ($package['is_popular']): ?>
                                        <div class="badge bg-primary text-white position-absolute top-0 start-50 translate-middle">
                                            Most Popular</div>
                                    <?php endif; ?>
                                    <div class="icon"><i class="<?php echo $package['icon'] ?? 'fas fa-home'; ?>"></i>
                                    </div>
                                    <h4><?php echo $package['package_name']; ?></h4>
                                    <div class="display-6 text-primary fw-bold mb-3">
                                        ₹<?php echo number_format($package['price'] / 100000, 1); ?>L</div>
                                    <p class="text-muted mb-3"><?php echo $package['description']; ?></p>
                                    <?php if (!empty($package['features'])): ?>
                                        <ul class="list-unstyled text-start mb-4">
                                            <?php
                                            $features = json_decode($package['features'], true);
                                            if (is_array($features)):
                                                foreach ($features as $feature):
                                                    ?>
                                                    <li>✓ <?php echo $feature; ?></li>
                                                <?php endforeach; endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <div class="mt-auto">
                                        <?php if ($package['subsidized_price'] && $package['subsidized_price'] < $package['price']): ?>
                                            <p class="text-success fw-bold">Final Price:
                                                ₹<?php echo number_format($package['subsidized_price'] / 100000, 2); ?>L*</p>
                                        <?php endif; ?>
                                        <a href="<?php echo base_url('contact'); ?>"
                                            class="btn <?php echo $package['is_popular'] ? 'btn-primary' : 'btn-outline-primary'; ?>">Get
                                            Quote</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback content if no packages in database -->
                        <div class="col-lg-4 col-md-6">
                            <div class="service-card text-center h-100">
                                <div class="icon"><i class="fas fa-home"></i></div>
                                <h4>Basic Home Package</h4>
                                <div class="display-6 text-primary fw-bold mb-3">₹2.5L</div>
                                <p class="text-muted mb-3">3kW System | Perfect for small families</p>
                                <div class="mt-auto">
                                    <p class="text-success fw-bold">Final Price: ₹1.96L*</p>
                                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-outline-primary">Get
                                        Quote</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="service-card text-center h-100 border-primary">
                                <div class="badge bg-primary text-white position-absolute top-0 start-50 translate-middle">
                                    Most Popular</div>
                                <div class="icon"><i class="fas fa-star"></i></div>
                                <h4>Family Plus Package</h4>
                                <div class="display-6 text-primary fw-bold mb-3">₹3.8L</div>
                                <p class="text-muted mb-3">5kW System | Ideal for medium families</p>
                                <div class="mt-auto">
                                    <p class="text-success fw-bold">Final Price: ₹3.02L*</p>
                                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-primary">Get Quote</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="service-card text-center h-100">
                                <div class="icon"><i class="fas fa-building"></i></div>
                                <h4>Premium Villa Package</h4>
                                <div class="display-6 text-primary fw-bold mb-3">₹6.5L</div>
                                <p class="text-muted mb-3">10kW System | Large homes & villas</p>
                                <div class="mt-auto">
                                    <p class="text-success fw-bold">Final Price: ₹5.72L*</p>
                                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-outline-primary">Get
                                        Quote</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Commercial Packages -->
                <h3 class="text-center mb-4 text-primary">🏢 Commercial Solar Solutions</h3>
                <div class="row g-4 mb-5">
                    <?php if (!empty($commercialPackages)): ?>
                        <?php foreach ($commercialPackages as $package): ?>
                            <div class="col-lg-6">
                                <div class="service-card h-100">
                                    <h4 class="text-center"><?php echo $package['package_name']; ?></h4>
                                    <div class="text-center mb-3">
                                        <span
                                            class="display-6 text-primary fw-bold">₹<?php echo number_format($package['price'] / 100000, 0); ?>L+</span>
                                        <p class="text-muted"><?php echo $package['description']; ?></p>
                                    </div>
                                    <?php if (!empty($package['features'])): ?>
                                        <?php
                                        $features = json_decode($package['features'], true);
                                        if (is_array($features)):
                                            $halfCount = ceil(count($features) / 2);
                                            $firstHalf = array_slice($features, 0, $halfCount);
                                            $secondHalf = array_slice($features, $halfCount);
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <ul class="list-unstyled">
                                                        <?php foreach ($firstHalf as $feature): ?>
                                                            <li>✓ <?php echo $feature; ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul class="list-unstyled">
                                                        <?php foreach ($secondHalf as $feature): ?>
                                                            <li>✓ <?php echo $feature; ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php endif; endif; ?>
                                    <div class="text-center">
                                        <a href="<?php echo base_url('contact'); ?>" class="btn btn-primary">
                                            <?php echo strpos(strtolower($package['package_name']), 'industrial') !== false ? 'Schedule Site Visit' : 'Get Custom Quote'; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback commercial packages -->
                        <div class="col-lg-6">
                            <div class="service-card h-100">
                                <h4 class="text-center">Small Business Package</h4>
                                <div class="text-center mb-3">
                                    <span class="display-6 text-primary fw-bold">₹15L+</span>
                                    <p class="text-muted">25kW System | Offices, Clinics, Shops</p>
                                </div>
                                <div class="text-center">
                                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-primary">Get Custom
                                        Quote</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="service-card h-100">
                                <h4 class="text-center">Industrial Package</h4>
                                <div class="text-center mb-3">
                                    <span class="display-6 text-primary fw-bold">₹50L+</span>
                                    <p class="text-muted">100kW+ System | Factories, Industries</p>
                                </div>
                                <div class="text-center">
                                    <a href="<?php echo base_url('contact'); ?>" class="btn btn-primary">Schedule Site
                                        Visit</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Financing Options -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="financing-section p-4 p-md-5 text-white rounded shadow"
                            style="background: linear-gradient(135deg, #2c5f41 0%, #4a7c59 100%); min-height: 400px;">
                            <div class="text-center mb-5">
                                <h3 class="mb-3">💳 Flexible Financing Options</h3>
                                <p class="lead opacity-90">Make solar affordable with our flexible payment plans</p>
                            </div>

                            <div class="row g-4 mb-5">
                                <div class="col-lg-4 col-md-6">
                                    <div class="financing-card text-center h-100 p-4 rounded"
                                        style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                                        <div class="mb-3">
                                            <i class="fas fa-hand-holding-usd fa-3x text-warning"></i>
                                        </div>
                                        <h5 class="fw-bold mb-3">Zero Down Payment</h5>
                                        <p class="mb-0">Start saving from day one with our zero investment option.
                                            Government subsidy covers your down payment.</p>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <div class="financing-card text-center h-100 p-4 rounded"
                                        style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                                        <div class="mb-3">
                                            <i class="fas fa-credit-card fa-3x text-info"></i>
                                        </div>
                                        <h5 class="fw-bold mb-3">Easy EMI Options</h5>
                                        <p class="mb-0">Flexible EMI plans from 3-60 months. Your monthly EMI will be
                                            less than your current electricity bill.</p>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12">
                                    <div class="financing-card text-center h-100 p-4 rounded"
                                        style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                                        <div class="mb-3">
                                            <i class="fas fa-percentage fa-3x text-success"></i>
                                        </div>
                                        <h5 class="fw-bold mb-3">Low Interest Rates</h5>
                                        <p class="mb-0">Special solar loan rates starting from 9.5% annual interest
                                            through our banking partners.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="<?php echo base_url('contact'); ?>"
                                    class="btn btn-light btn-lg px-5 py-3 fw-bold">
                                    <i class="fas fa-calculator me-2"></i>Calculate My EMI
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <p class="text-muted">* Final prices after government subsidy. Prices may vary based on site
                        conditions and requirements.<br>
                        All packages include: Installation, commissioning, net metering, government approvals, and
                        5-year comprehensive warranty.</p>
                </div>
            </div>
        </section>
    </main>
    <?php echo view("shared/view_footer"); ?>
    <?php echo view("shared/view_scripts"); ?>
</body>

</html>