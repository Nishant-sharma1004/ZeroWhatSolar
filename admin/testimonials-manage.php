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
    
    if ($action === 'create') {
        try {
            $data = [
                'customer_name' => $_POST['customer_name'],
                'location' => $_POST['location'],
                'testimonial_text' => $_POST['testimonial_text'],
                'rating' => $_POST['rating'],
                'system_size_kw' => $_POST['system_size_kw'] ?: null,
                'savings_amount' => $_POST['savings_amount'] ?: null,
                'customer_image' => $_POST['customer_image'] ?: null,
                'featured' => isset($_POST['featured']) ? 1 : 0,
                'status' => $_POST['status']
            ];
            
            $testimonialId = $db->insert('testimonials', $data);
            $success = "Testimonial created successfully!";
        } catch (Exception $e) {
            $error = "Error creating testimonial: " . $e->getMessage();
        }
    }
    
    if ($action === 'update') {
        try {
            $data = [
                'customer_name' => $_POST['customer_name'],
                'location' => $_POST['location'],
                'testimonial_text' => $_POST['testimonial_text'],
                'rating' => $_POST['rating'],
                'system_size_kw' => $_POST['system_size_kw'] ?: null,
                'savings_amount' => $_POST['savings_amount'] ?: null,
                'customer_image' => $_POST['customer_image'] ?: null,
                'featured' => isset($_POST['featured']) ? 1 : 0,
                'status' => $_POST['status'],
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->update('testimonials', $data, 'id = ?', [$_POST['testimonial_id']]);
            $success = "Testimonial updated successfully!";
        } catch (Exception $e) {
            $error = "Error updating testimonial: " . $e->getMessage();
        }
    }
    
    if ($action === 'delete') {
        try {
            $db->delete('testimonials', 'id = ?', [$_POST['testimonial_id']]);
            $success = "Testimonial deleted successfully!";
        } catch (Exception $e) {
            $error = "Error deleting testimonial: " . $e->getMessage();
        }
    }
}

// Get all testimonials
$testimonials = $db->fetchAll("SELECT * FROM testimonials ORDER BY created_at DESC");

// Get statistics
$totalTestimonials = count($testimonials);
$approvedTestimonials = count(array_filter($testimonials, function($t) { return $t['status'] === 'approved'; }));
$pendingTestimonials = count(array_filter($testimonials, function($t) { return $t['status'] === 'pending'; }));
$featuredTestimonials = count(array_filter($testimonials, function($t) { return $t['featured'] == 1; }));

// Get specific testimonial for editing
$editTestimonial = null;
if (isset($_GET['edit'])) {
    $editTestimonial = $db->fetch("SELECT * FROM testimonials WHERE id = ?", [$_GET['edit']]);
}
?>

<?php
$page_title = 'Testimonials Management';
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
        
        .stats-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
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
        
        .table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .table thead {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
            color: white;
        }
        
        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        
        .customer-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .badge {
            font-size: 0.8em;
            padding: 0.5em 0.8em;
        }
        
        .testimonial-text {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .star-rating {
            color: #ffc107;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-blue);
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
                <div class="admin-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">Testimonials Management</h2>
                            <p class="text-muted mb-0">Manage customer testimonials and reviews</p>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testimonialModal">
                            <i class="fas fa-plus me-2"></i>Add New Testimonial
                        </button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-card text-center">
                            <div class="stats-number"><?php echo $totalTestimonials; ?></div>
                            <div class="text-muted">Total Testimonials</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-card text-center">
                            <div class="stats-number text-success"><?php echo $approvedTestimonials; ?></div>
                            <div class="text-muted">Approved</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-card text-center">
                            <div class="stats-number text-warning"><?php echo $pendingTestimonials; ?></div>
                            <div class="text-muted">Pending</div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stats-card text-center">
                            <div class="stats-number text-primary"><?php echo $featuredTestimonials; ?></div>
                            <div class="text-muted">Featured</div>
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

                <!-- Testimonials Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Location</th>
                                <th>Testimonial</th>
                                <th>Rating</th>
                                <th>System Size</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($testimonials as $testimonial): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($testimonial['customer_image']): ?>
                                            <img src="<?php echo htmlspecialchars($testimonial['customer_image']); ?>" 
                                                 class="customer-image me-3" alt="Customer">
                                        <?php else: ?>
                                            <div class="customer-image bg-light d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <strong><?php echo htmlspecialchars($testimonial['customer_name']); ?></strong>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($testimonial['location']); ?></td>
                                <td>
                                    <div class="testimonial-text" title="<?php echo htmlspecialchars($testimonial['testimonial_text']); ?>">
                                        <?php echo htmlspecialchars($testimonial['testimonial_text']); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="star-rating">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star<?php echo ($i <= $testimonial['rating']) ? '' : '-o'; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $testimonial['system_size_kw'] ? number_format($testimonial['system_size_kw'], 1) . ' kW' : '-'; ?>
                                </td>
                                <td>
                                    <?php 
                                    $statusColors = [
                                        'approved' => 'success',
                                        'pending' => 'warning',
                                        'rejected' => 'danger'
                                    ];
                                    $color = $statusColors[$testimonial['status']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?php echo $color; ?>">
                                        <?php echo ucfirst($testimonial['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($testimonial['featured']): ?>
                                        <span class="badge bg-warning">Featured</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $testimonial['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="testimonial_id" value="<?php echo $testimonial['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial Modal -->
    <div class="modal fade" id="testimonialModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?php echo $editTestimonial ? 'Edit Testimonial' : 'Add New Testimonial'; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="<?php echo $editTestimonial ? 'update' : 'create'; ?>">
                        <?php if ($editTestimonial): ?>
                            <input type="hidden" name="testimonial_id" value="<?php echo $editTestimonial['id']; ?>">
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name *</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                           value="<?php echo $editTestimonial ? htmlspecialchars($editTestimonial['customer_name']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location *</label>
                                    <input type="text" class="form-control" id="location" name="location" 
                                           value="<?php echo $editTestimonial ? htmlspecialchars($editTestimonial['location']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="testimonial_text" class="form-label">Testimonial Text *</label>
                            <textarea class="form-control" id="testimonial_text" name="testimonial_text" rows="4" required><?php echo $editTestimonial ? htmlspecialchars($editTestimonial['testimonial_text']) : ''; ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating *</label>
                                    <select class="form-control" id="rating" name="rating" required>
                                        <option value="">Select Rating</option>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?php echo $i; ?>" 
                                                    <?php echo ($editTestimonial && $editTestimonial['rating'] == $i) ? 'selected' : ''; ?>>
                                                <?php echo $i; ?> Star<?php echo $i > 1 ? 's' : ''; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="system_size_kw" class="form-label">System Size (kW)</label>
                                    <input type="number" step="0.01" class="form-control" id="system_size_kw" name="system_size_kw" 
                                           value="<?php echo $editTestimonial ? $editTestimonial['system_size_kw'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="savings_amount" class="form-label">Monthly Savings (₹)</label>
                                    <input type="number" step="0.01" class="form-control" id="savings_amount" name="savings_amount" 
                                           value="<?php echo $editTestimonial ? $editTestimonial['savings_amount'] : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="customer_image" class="form-label">Customer Image URL</label>
                                    <input type="text" class="form-control" id="customer_image" name="customer_image" 
                                           value="<?php echo $editTestimonial ? htmlspecialchars($editTestimonial['customer_image']) : ''; ?>"
                                           placeholder="Enter image URL or use quick select below">
                                    <div class="form-text mt-2">
                                        <strong>Quick Select Available Images:</strong><br>
                                        <button type="button" class="btn btn-sm btn-outline-primary me-2 mt-1" onclick="document.getElementById('customer_image').value='assets/images/person1.jpg'">👨 Person 1</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary me-2 mt-1" onclick="document.getElementById('customer_image').value='assets/images/person2.jpg'">👩 Person 2</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="document.getElementById('customer_image').value='assets/images/Person3.jpg'">👨 Person 3</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="pending" <?php echo ($editTestimonial && $editTestimonial['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="approved" <?php echo ($editTestimonial && $editTestimonial['status'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                                        <option value="rejected" <?php echo ($editTestimonial && $editTestimonial['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" 
                                       <?php echo ($editTestimonial && $editTestimonial['featured']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="featured">
                                    Featured Testimonial
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <?php echo $editTestimonial ? 'Update Testimonial' : 'Create Testimonial'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if ($editTestimonial): ?>
    <script>
        // Show modal if editing
        var testimonialModal = new bootstrap.Modal(document.getElementById('testimonialModal'));
        testimonialModal.show();
    </script>
    <?php endif; ?>
</body>
</html>