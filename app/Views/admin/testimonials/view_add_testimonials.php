<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view('admin/shared/view_links'); ?>
</head>

<body>
    <?php echo view('admin/shared/view_sidebar'); ?>

    <!-- Main Content -->
    <div class="main-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add Testimonial</h2>
            <a href="<?php echo ADMIN_URL . 'testimonials'; ?>" class="btn btn-primary">
                <i class="fas fa-minus me-2"></i>View All Testimonials
            </a>
        </div>

        <div class="alert alert-dismissible" style="display:none">
            <div class="msg"></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Add/Edit Form -->
        <form id="add_testimonials" name="add_testimonials" action="save-testimonials" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name *</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value=""
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location *</label>
                            <input type="text" class="form-control" id="location" name="location" value="" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="testimonial_text" class="form-label">Testimonial Text *</label>
                    <textarea class="form-control" id="testimonial_text" name="testimonial_text" rows="4"
                        required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating *</label>
                            <select class="form-control" id="rating" name="rating" required>
                                <option value="">Select Rating</option>
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?>
                                        Star<?php echo $i > 1 ? 's' : ''; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="system_size_kw" class="form-label">System Size (kW)</label>
                            <input type="number" step="0.01" class="form-control" id="system_size_kw"
                                name="system_size_kw" value="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="savings_amount" class="form-label">Monthly Savings (₹)</label>
                            <input type="number" step="0.01" class="form-control" id="savings_amount"
                                name="savings_amount" value="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="customer_image" class="form-label">Upload Customer Image</label>
                            <input type="file" class="form-control" id="customer_image" name="customer_image" value="" placeholder="Enter image URL or use quick select below">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="featured" name="featured">
                        <label class="form-check-label" for="featured">
                            Featured Testimonial
                        </label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Create Testimonial
                </button>
                <a href="<?php echo ADMIN_URL . 'testimonials'; ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ASSETS_PATH . 'admin/js/testimonials.js?rand=' . RAND; ?>"></script>
</body>

</html>