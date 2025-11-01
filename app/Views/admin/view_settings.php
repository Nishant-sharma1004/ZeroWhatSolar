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

        .settings-card {
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
    </style>
</head>

<body>
    <?php echo view('admin/shared/view_sidebar'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="admin-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Site Settings</h2>
                    <p class="text-muted mb-0">Manage your website configuration and settings</p>
                </div>
            </div>
        </div>

        <div class="alert alert-dismissible" style="display:none">
            <div class="msg"></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <form id="update-setting" name="update-setting" action="update-settings">
            <!-- Company Information -->
            <div class="settings-card">
                <h4 class="section-title">
                    <i class="fas fa-building me-2"></i>Company Information
                </h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name"
                                value="<?php echo $currentSettings['company_name'] ?? 'Zero What Solar'; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company_tagline" class="form-label">Company Tagline</label>
                            <input type="text" class="form-control" id="company_tagline" name="company_tagline"
                                value="<?php echo $currentSettings['company_tagline'] ?? 'POWERING A BRIGHTER FUTURE'; ?>">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="office_address" class="form-label">Office Address</label>
                    <textarea class="form-control" id="office_address" name="office_address"
                        rows="3"><?php echo $currentSettings['office_address'] ?? 'Jaipur, Rajasthan, India'; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="gst_number" class="form-label">GST Number</label>
                    <input type="text" class="form-control" id="gst_number" name="gst_number"
                        value="<?php echo $currentSettings['gst_number'] ?? '' ?>">
                </div>
            </div>

            <!-- Contact Information -->
            <div class="settings-card">
                <h4 class="section-title">
                    <i class="fas fa-phone me-2"></i>Contact Information
                </h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Contact Email</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email"
                                value="<?php echo $currentSettings['contact_email'] ?? 'contact@zerowhatsolar.in'; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">Contact Phone</label>
                            <input type="tel" class="form-control" id="contact_phone" name="contact_phone"
                                value="<?php echo $currentSettings['contact_phone'] ?? '+91 9876543210'; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                            <input type="tel" class="form-control" id="whatsapp_number" name="whatsapp_number"
                                value="<?php echo $currentSettings['whatsapp_number'] ?? '+919876543210'; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="settings-card">
                <h4 class="section-title">
                    <i class="fas fa-share-alt me-2"></i>Social Media Links
                </h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="facebook_url" class="form-label">Facebook URL</label>
                            <input type="text" class="form-control" id="facebook_url" name="facebook_url"
                                value="<?php echo $currentSettings['facebook_url'] ?? ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="twitter_url" class="form-label">Twitter URL</label>
                            <input type="text" class="form-control" id="twitter_url" name="twitter_url"
                                value="<?php echo $currentSettings['twitter_url'] ?? '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="instagram_url" class="form-label">Instagram URL</label>
                            <input type="text" class="form-control" id="instagram_url" name="instagram_url"
                                value="<?php echo $currentSettings['instagram_url'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                            <input type="text" class="form-control" id="linkedin_url" name="linkedin_url"
                                value="<?php echo $currentSettings['linkedin_url'] ?? '' ?>">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="youtube_url" class="form-label">YouTube URL</label>
                    <input type="text" class="form-control" id="youtube_url" name="youtube_url"
                        value="<?php echo $currentSettings['youtube_url'] ?? '' ?>">
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="settings-card">
                <h4 class="section-title">
                    <i class="fas fa-search me-2"></i>SEO Settings
                </h4>
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3"
                        placeholder="Enter site meta description for search engines"><?php echo $currentSettings['meta_description'] ?? 'Zero What Solar - Leading solar panel installation company in Jaipur. Get premium solar solutions with government subsidy. Contact us for free consultation.'; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                        value="<?php echo $currentSettings['meta_keywords'] ?? 'solar panels, solar installation, jaipur solar, solar subsidy, renewable energy'; ?>"
                        placeholder="Comma-separated keywords">
                </div>
                <div class="mb-3">
                    <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                    <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id"
                        value="<?php echo $currentSettings['google_analytics_id'] ?? '' ?>" placeholder="GA-XXXXXXXXX">
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Save Settings
                </button>
            </div>
        </form>
    </div>

    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ASSETS_PATH; ?>admin/js/setting.js?rand=" . RAND></script>
</body>

</html>