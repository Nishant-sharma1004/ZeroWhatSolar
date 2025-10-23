<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Check session timeout
if (isset($_SESSION['admin_login_time']) && (time() - $_SESSION['admin_login_time'] > 3600)) {
    session_destroy();
    header('Location: index.php?timeout=1');
    exit();
}

require_once '../config/database.php';

$db = Database::getInstance();
$success = '';
$error = '';

// Handle form submissions
if ($_POST) {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_settings') {
        try {
            // Update or insert settings
            $settings = [
                'company_name' => $_POST['company_name'] ?? '',
                'company_tagline' => $_POST['company_tagline'] ?? '',
                'contact_email' => $_POST['contact_email'] ?? '',
                'contact_phone' => $_POST['contact_phone'] ?? '',
                'whatsapp_number' => $_POST['whatsapp_number'] ?? '',
                'office_address' => $_POST['office_address'] ?? '',
                'gst_number' => $_POST['gst_number'] ?? '',
                'facebook_url' => $_POST['facebook_url'] ?? '',
                'twitter_url' => $_POST['twitter_url'] ?? '',
                'instagram_url' => $_POST['instagram_url'] ?? '',
                'linkedin_url' => $_POST['linkedin_url'] ?? '',
                'youtube_url' => $_POST['youtube_url'] ?? '',
                'google_analytics_id' => $_POST['google_analytics_id'] ?? '',
                'meta_description' => $_POST['meta_description'] ?? '',
                'meta_keywords' => $_POST['meta_keywords'] ?? ''
            ];
            
            foreach ($settings as $key => $value) {
                // Check if setting exists
                $existingSetting = $db->fetch("SELECT id FROM site_settings WHERE setting_key = ?", [$key]);
                
                if ($existingSetting) {
                    // Update existing setting
                    $db->update('site_settings', 
                        ['setting_value' => $value, 'updated_at' => date('Y-m-d H:i:s')], 
                        'setting_key = ?', 
                        [$key]
                    );
                } else {
                    // Insert new setting
                    $db->insert('site_settings', [
                        'setting_key' => $key,
                        'setting_value' => $value,
                        'setting_type' => 'text',
                        'description' => ucwords(str_replace('_', ' ', $key))
                    ]);
                }
            }
            
            $success = "Settings updated successfully!";
        } catch (Exception $e) {
            $error = "Error updating settings: " . $e->getMessage();
        }
    }
}

// Get current settings
$currentSettings = [];
$settings = $db->fetchAll("SELECT setting_key, setting_value FROM site_settings");
foreach ($settings as $setting) {
    $currentSettings[$setting['setting_key']] = $setting['setting_value'];
}

// Function to get setting value with default
function getSetting($key, $default = '') {
    global $currentSettings;
    return $currentSettings[$key] ?? $default;
}
?>

<?php
$page_title = 'Site Settings';
include 'includes/header.php';
?>
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        
        .settings-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
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
    <?php include 'includes/sidebar.php'; ?>
                <div class="admin-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">Site Settings</h2>
                            <p class="text-muted mb-0">Manage your website configuration and settings</p>
                        </div>
                    </div>
                </div>

                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <input type="hidden" name="action" value="update_settings">
                    
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
                                           value="<?php echo htmlspecialchars(getSetting('company_name', 'Zero What Solar')); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_tagline" class="form-label">Company Tagline</label>
                                    <input type="text" class="form-control" id="company_tagline" name="company_tagline" 
                                           value="<?php echo htmlspecialchars(getSetting('company_tagline', 'POWERING A BRIGHTER FUTURE')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="office_address" class="form-label">Office Address</label>
                            <textarea class="form-control" id="office_address" name="office_address" rows="3"><?php echo htmlspecialchars(getSetting('office_address', 'Jaipur, Rajasthan, India')); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gst_number" class="form-label">GST Number</label>
                            <input type="text" class="form-control" id="gst_number" name="gst_number" 
                                   value="<?php echo htmlspecialchars(getSetting('gst_number')); ?>">
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
                                           value="<?php echo htmlspecialchars(getSetting('contact_email', 'contact@zerowhatsolar.in')); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Contact Phone</label>
                                    <input type="tel" class="form-control" id="contact_phone" name="contact_phone" 
                                           value="<?php echo htmlspecialchars(getSetting('contact_phone', '+91 9876543210')); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                    <input type="tel" class="form-control" id="whatsapp_number" name="whatsapp_number" 
                                           value="<?php echo htmlspecialchars(getSetting('whatsapp_number', '+919876543210')); ?>">
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
                                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" 
                                           value="<?php echo htmlspecialchars(getSetting('facebook_url')); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="twitter_url" class="form-label">Twitter URL</label>
                                    <input type="url" class="form-control" id="twitter_url" name="twitter_url" 
                                           value="<?php echo htmlspecialchars(getSetting('twitter_url')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instagram_url" class="form-label">Instagram URL</label>
                                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" 
                                           value="<?php echo htmlspecialchars(getSetting('instagram_url')); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                    <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" 
                                           value="<?php echo htmlspecialchars(getSetting('linkedin_url')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="youtube_url" class="form-label">YouTube URL</label>
                            <input type="url" class="form-control" id="youtube_url" name="youtube_url" 
                                   value="<?php echo htmlspecialchars(getSetting('youtube_url')); ?>">
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
                                      placeholder="Enter site meta description for search engines"><?php echo htmlspecialchars(getSetting('meta_description', 'Zero What Solar - Leading solar panel installation company in Jaipur. Get premium solar solutions with government subsidy. Contact us for free consultation.')); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" 
                                   value="<?php echo htmlspecialchars(getSetting('meta_keywords', 'solar panels, solar installation, jaipur solar, solar subsidy, renewable energy')); ?>" 
                                   placeholder="Comma-separated keywords">
                        </div>
                        <div class="mb-3">
                            <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                            <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id" 
                                   value="<?php echo htmlspecialchars(getSetting('google_analytics_id')); ?>" 
                                   placeholder="GA-XXXXXXXXX">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>