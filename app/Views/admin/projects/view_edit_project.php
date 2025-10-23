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
            <h2>Edit Project</h2>
            <a href="<?php echo ADMIN_URL . 'projects'; ?>" class="btn btn-primary">
                <i class="fas fa-minus me-2"></i>View All Projects
            </a>
        </div>

        <div class="alert alert-dismissible" style="display:none">
            <div class="msg"></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Add/Edit Form -->
        <form id="edit_project" name="edit_project" enctype="multipart/form-data" action="update-project">
            <input type="hidden" name="url" value="<?php echo isset($project->url) ? $project->url : ''; ?>">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Project Title *</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="<?php echo isset($project->title) ? $project->title : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Location *</label>
                            <input type="text" class="form-control" id="location" name="location"
                                value="<?php echo isset($project->location) ? $project->location : ''; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"
                        rows="3"><?php echo isset($project->description) ? $project->description : ''; ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="system_size_kw" class="form-label">System Size (kW) *</label>
                            <input type="number" step="0.01" class="form-control" id="system_size_kw"
                                name="system_size_kw"
                                value="<?php echo isset($project->system_size_kw) ? $project->system_size_kw : ''; ?>"
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="project_cost" class="form-label">Project Cost (₹)</label>
                            <input type="number" step="0.01" class="form-control" id="project_cost" name="project_cost"
                                value="<?php echo isset($project->project_cost) ? $project->project_cost : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="monthly_savings" class="form-label">Monthly Savings (₹)</label>
                            <input type="number" step="0.01" class="form-control" id="monthly_savings"
                                name="monthly_savings"
                                value="<?php echo isset($project->monthly_savings) ? $project->monthly_savings : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="roi_years" class="form-label">ROI Period (Years)</label>
                            <input type="number" step="0.1" class="form-control" id="roi_years" name="roi_years"
                                value="<?php echo isset($project->roi_years) ? $project->roi_years : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category->id; ?>" <?php echo isset($project->category_id) && $project->category_id == $category->id ? 'selected' : ''; ?>>
                                        <?php echo $category->name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="completed" <?php echo isset($project->project_status) && $project->project_status == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="ongoing" <?php echo isset($project->project_status) && $project->project_status == 'ongoing' ? 'selected' : ''; ?>>Ongoing</option>
                                <option value="planned" <?php echo isset($project->project_status) && $project->project_status == 'planned' ? 'selected' : ''; ?>>Planned</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="completion_date" class="form-label">Completion Date</label>
                            <input type="date" class="form-control" id="completion_date" name="completion_date"
                                value="<?php echo $project->completion_date; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="featured_image" class="form-label">Upload Image</label>
                            <input type="file" class="form-control" id="featured_image" name="featured_image"
                                accept=".jpg, .jpeg, .png, .webp, .avif">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="featured" name="featured" <?php echo isset($project->featured) && $project->featured == 1 ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="featured">
                            Featured Project
                        </label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Project
                </button>
                <a href="<?php echo ADMIN_URL . 'projects'; ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ASSETS_PATH . 'admin/js/project.js?rand=' . RAND; ?>"></script>
</body>

</html>