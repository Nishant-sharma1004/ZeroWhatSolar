<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo view('admin/shared/view_links'); ?>
    <style>
        .project-image {
            width: 50px;
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
                    <h2 class="mb-0">Projects Management</h2>
                    <p class="text-muted mb-0">Manage your solar installation projects</p>
                </div>
                <a href="<?php echo ADMIN_URL . 'add-project' ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Project
                </a>
            </div>
        </div>

        <div class="alert alert-dismissible" style="display:none">
            <div class="msg"></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Projects Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">All Projects (<?php echo count($projects); ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($projects)) { ?>
                    <p class="text-muted text-center py-4">No project found. <a
                            href="<?php echo ADMIN_URL . 'add-project'; ?>">Create new project</a>.</p>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Location</th>
                                    <th>System Size</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project) { ?>
                                    <tr>
                                        <td><?php echo $count++?></td>
                                        <td>
                                            <?php if ($project->featured_image) { ?>
                                                <img src="<?php echo ASSETS_PATH . 'upload_images/projects/' . $project->featured_image; ?>"
                                                    class="project-image" alt="Project Image">
                                            <?php } else { ?>
                                                <div
                                                    class="project-image bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <strong><?php echo $project->title; ?></strong>
                                            <?php if ($project->category_name) { ?>
                                                <br><small class="text-muted"><?php echo $project->category_name; ?></small>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $project->location; ?></td>
                                        <td><?php echo number_format($project->system_size_kw, 1); ?> kW</td>
                                        <td>
                                            <?php
                                            $statusColors = [
                                                'completed' => 'success',
                                                'ongoing' => 'warning',
                                                'planned' => 'info'
                                            ];
                                            $color = $statusColors[$project->project_status] ?? 'secondary';
                                            ?>
                                            <span class="badge bg-<?php echo $color; ?>">
                                                <?php echo ucfirst($project->project_status); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($project->featured) { ?>
                                                <span class="badge bg-warning">Featured</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo ADMIN_URL . 'edit-project/' . $project->url; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="deletePost('<?php echo $project->url; ?>', '<?php echo $project->title; ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
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
                    <p>Are you sure you want to delete this project?</p>
                    <p><strong id="deleteTitle"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form style="display: inline;" action="delete-project" id="delete_project">
                        <input type="hidden" name="url" id="deleteUrl">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ASSETS_PATH . 'admin/js/project.js?rand=' . RAND; ?>"></script>
</body>

</html>