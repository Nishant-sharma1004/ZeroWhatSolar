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

        .stats-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
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
    <?php echo view('admin/shared/view_sidebar'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="admin-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Testimonials Management</h2>
                    <p class="text-muted mb-0">Manage customer testimonials and reviews</p>
                </div>
                <a href="<?php echo ADMIN_URL . 'add-testimonials' ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Testimonials
                </a>
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

        <div class="alert alert-dismissible" style="display:none">
            <div class="msg"></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Testimonials Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
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
                    <?php foreach ($testimonials as $testimonial) { ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if ($testimonial->customer_image) { ?>
                                        <img src="<?php echo ASSETS_PATH . 'upload_images/testimonials/' . $testimonial->customer_image; ?>"
                                            class="customer-image me-3" alt="Customer">
                                    <?php } else { ?>
                                        <div
                                            class="customer-image bg-light d-flex align-items-center justify-content-center me-3">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                    <?php } ?>
                                    <div>
                                        <strong><?php echo $testimonial->customer_name; ?></strong>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $testimonial->location; ?></td>
                            <td>
                                <div class="testimonial-text" title="<?php echo $testimonial->testimonial_text; ?>">
                                    <?php echo $testimonial->testimonial_text; ?>
                                </div>
                            </td>
                            <td>
                                <div class="star-rating">
                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                        <i class="fas fa-star<?php echo ($i <= $testimonial->rating) ? '' : '-o'; ?>"></i>
                                    <?php } ?>
                                </div>
                            </td>
                            <td>
                                <?php echo $testimonial->system_size_kw ? number_format($testimonial->system_size_kw, 1) . ' kW' : '-'; ?>
                            </td>
                            <td>
                                <?php
                                $statusColors = [
                                    'approved' => 'success',
                                    'pending' => 'warning',
                                    'rejected' => 'danger'
                                ];
                                $color = $statusColors[$testimonial->status] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?php echo $color; ?>">
                                    <?php echo ucfirst($testimonial->status); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($testimonial->featured) { ?>
                                    <span class="badge bg-warning">Featured</span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="<?php echo ADMIN_URL . 'edit-testimonials/' . $testimonial->url; ?>"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="deletePost('<?php echo $testimonial->url; ?>', '<?php echo $testimonial->testimonial_text; ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this testimonials?</p>
                    <p><strong id="deleteTitle"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form style="display: inline;" action="delete-testimonials" id="delete_testimonials">
                        <input type="hidden" name="url" id="deleteUrl">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ASSETS_PATH . 'admin/js/testimonials.js?rand=' . RAND; ?>"></script>
</body>

</html>