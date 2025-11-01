<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view('admin/shared/view_links'); ?>

    <style>
        :root {
            --primary-blue: #1E3A8A;
            --accent-blue: #3B82F6;
            --gradient-blue: #1D4ED8;
            --gradient-light: #60A5FA;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
            min-height: 100vh;
            padding: 0;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 25px;
            margin: 5px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(5px);
        }

        .main-content {
            padding: 30px;
        }

        .admin-header {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .pricing-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-blue), var(--primary-blue));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
        }

        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .section-title {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--accent-blue);
        }

        .pricing-preview {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .calculator-demo {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <?php echo view('admin/shared/view_sidebar'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="admin-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Pricing Management</h2>
                    <p class="text-muted mb-0">Configure solar installation pricing and calculator settings</p>
                </div>
            </div>
        </div>

        <div class="alert alert-dismissible" style="display:none">
            <div class="msg"></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <form id="update-pricing" name="update_pricing" action="update-pricing">
            <input type="hidden" name="action" value="update_pricing">

            <!-- Residential Pricing -->
            <div class="pricing-card">
                <h4 class="section-title">
                    <i class="fas fa-home me-2"></i>Residential Pricing
                </h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="residential_base_price" class="form-label">Base Price (₹)</label>
                            <input type="number" class="form-control" id="residential_base_price"
                                name="residential_base_price"
                                value="<?php echo $currentPricing['residential_base_price'] ?? 50000; ?>" min="0">
                            <div class="form-text">Fixed installation cost</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="residential_price_per_kw" class="form-label">Price per kW (₹)</label>
                            <input type="number" class="form-control" id="residential_price_per_kw"
                                name="residential_price_per_kw" value="<?php echo $currentPricing['residential_price_per_kw'] ?? 50000;
                                ; ?>" min="0">
                            <div class="form-text">Cost per kilowatt</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="residential_subsidy_percentage" class="form-label">Subsidy (%)</label>
                            <input type="number" class="form-control" id="residential_subsidy_percentage"
                                name="residential_subsidy_percentage"
                                value="<?php echo $currentPricing['residential_subsidy_percentage'] ?? 30; ?>" min="0"
                                max="100" step="1">
                            <div class="form-text">Government subsidy percentage</div>
                        </div>
                    </div>
                </div>

                <!-- Residential Pricing Preview -->
                <div class="pricing-preview">
                    <h6><i class="fas fa-calculator me-2"></i>Preview: 5kW Residential System</h6>
                    <div class="calculator-demo">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>System Cost:</strong><br>
                                <span id="res_system_cost">₹3,00,000</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Subsidy:</strong><br>
                                <span id="res_subsidy">₹90,000</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Final Cost:</strong><br>
                                <span id="res_final_cost">₹2,10,000</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Cost per kW:</strong><br>
                                <span id="res_cost_per_kw">₹42,000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Commercial Pricing -->
            <div class="pricing-card">
                <h4 class="section-title">
                    <i class="fas fa-building me-2"></i>Commercial Pricing
                </h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="commercial_base_price" class="form-label">Base Price (₹)</label>
                            <input type="number" class="form-control" id="commercial_base_price"
                                name="commercial_base_price"
                                value="<?php echo $currentPricing['commercial_base_price'] ?? 100000; ?>" min="0">
                            <div class="form-text">Fixed installation cost</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="commercial_price_per_kw" class="form-label">Price per kW (₹)</label>
                            <input type="number" class="form-control" id="commercial_price_per_kw"
                                name="commercial_price_per_kw"
                                value="<?php echo $currentPricing['commercial_price_per_kw'] ?? 45000; ?>" min="0">
                            <div class="form-text">Cost per kilowatt</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="commercial_subsidy_percentage" class="form-label">Subsidy (%)</label>
                            <input type="number" class="form-control" id="commercial_subsidy_percentage"
                                name="commercial_subsidy_percentage"
                                value="<?php echo $currentPricing['commercial_subsidy_percentage'] ?? 20; ?>" min="0"
                                max="100" step="1">
                            <div class="form-text">Government subsidy percentage</div>
                        </div>
                    </div>
                </div>

                <!-- Commercial Pricing Preview -->
                <div class="pricing-preview">
                    <h6><i class="fas fa-calculator me-2"></i>Preview: 10kW Commercial System</h6>
                    <div class="calculator-demo">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>System Cost:</strong><br>
                                <span id="com_system_cost">₹5,50,000</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Subsidy:</strong><br>
                                <span id="com_subsidy">₹1,10,000</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Final Cost:</strong><br>
                                <span id="com_final_cost">₹4,40,000</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Cost per kW:</strong><br>
                                <span id="com_cost_per_kw">₹44,000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General Settings -->
            <div class="pricing-card">
                <h4 class="section-title">
                    <i class="fas fa-cogs me-2"></i>General Settings
                </h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="installation_cost_percentage" class="form-label">Installation Cost (%)</label>
                            <input type="number" class="form-control" id="installation_cost_percentage"
                                name="installation_cost_percentage"
                                value="<?php echo $currentPricing['installation_cost_percentage'] ?? 15; ?>" min="5"
                                max="30" step="1">
                            <div class="form-text">% of total system cost</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="maintenance_annual_cost" class="form-label">Annual Maintenance (₹)</label>
                            <input type="number" class="form-control" id="maintenance_annual_cost"
                                name="maintenance_annual_cost"
                                value="<?php echo $currentPricing['maintenance_annual_cost'] ?? 5000; ?>" min="0"
                                step="500">
                            <div class="form-text">Yearly maintenance cost</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="warranty_years" class="form-label">Warranty (Years)</label>
                            <input type="number" class="form-control" id="warranty_years" name="warranty_years"
                                value="<?php echo $currentPricing['warranty_years'] ?? 25; ?>" min="10" max="30"
                                step="1">
                            <div class="form-text">Product warranty period</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="payback_period_years" class="form-label">Payback Period (Years)</label>
                            <input type="number" class="form-control" id="payback_period_years"
                                name="payback_period_years"
                                value="<?php echo $currentPricing['payback_period_years'] ?? 7; ?>" min="3" max="15"
                                step="0.5">
                            <div class="form-text">Average ROI period</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Update Pricing
                </button>
            </div>
        </form>
    </div>

    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ASSETS_PATH; ?>admin/js/setting.js?rand=" . RAND></script>

    <script>
        // Update pricing previews when values change
        function updatePreviews() {
            // Residential preview
            const resBase = parseFloat(document.getElementById('residential_base_price').value) || 0;
            const resPerKw = parseFloat(document.getElementById('residential_price_per_kw').value) || 0;
            const resSubsidy = parseFloat(document.getElementById('residential_subsidy_percentage').value) || 0;

            const resSystemCost = resBase + (resPerKw * 5); // 5kW system
            const resSubsidyAmount = (resSystemCost * resSubsidy) / 100;
            const resFinalCost = resSystemCost - resSubsidyAmount;

            document.getElementById('res_system_cost').textContent = '₹' + resSystemCost.toLocaleString('en-IN');
            document.getElementById('res_subsidy').textContent = '₹' + resSubsidyAmount.toLocaleString('en-IN');
            document.getElementById('res_final_cost').textContent = '₹' + resFinalCost.toLocaleString('en-IN');
            document.getElementById('res_cost_per_kw').textContent = '₹' + (resFinalCost / 5).toLocaleString('en-IN');

            // Commercial preview
            const comBase = parseFloat(document.getElementById('commercial_base_price').value) || 0;
            const comPerKw = parseFloat(document.getElementById('commercial_price_per_kw').value) || 0;
            const comSubsidy = parseFloat(document.getElementById('commercial_subsidy_percentage').value) || 0;

            const comSystemCost = comBase + (comPerKw * 10); // 10kW system
            const comSubsidyAmount = (comSystemCost * comSubsidy) / 100;
            const comFinalCost = comSystemCost - comSubsidyAmount;

            document.getElementById('com_system_cost').textContent = '₹' + comSystemCost.toLocaleString('en-IN');
            document.getElementById('com_subsidy').textContent = '₹' + comSubsidyAmount.toLocaleString('en-IN');
            document.getElementById('com_final_cost').textContent = '₹' + comFinalCost.toLocaleString('en-IN');
            document.getElementById('com_cost_per_kw').textContent = '₹' + (comFinalCost / 10).toLocaleString('en-IN');
        }

        // Add event listeners to update previews
        document.addEventListener('DOMContentLoaded', function () {
            updatePreviews();

            const priceInputs = document.querySelectorAll('input[type="number"]');
            priceInputs.forEach(input => {
                input.addEventListener('input', updatePreviews);
            });
        });
    </script>
</body>

</html>