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
                'title' => $_POST['title'],
                'slug' => strtolower(str_replace(' ', '-', $_POST['title'])),
                'description' => $_POST['description'],
                'location' => $_POST['location'],
                'system_size_kw' => $_POST['system_size_kw'],
                'monthly_savings' => $_POST['monthly_savings'],
                'roi_years' => $_POST['roi_years'],
                'project_cost' => $_POST['project_cost'],
                'category_id' => $_POST['category_id'] ?: null,
                'featured_image' => $_POST['featured_image'],
                'completion_date' => $_POST['completion_date'],
                'status' => $_POST['status'],
                'featured' => isset($_POST['featured']) ? 1 : 0
            ];
            
            $projectId = $db->insert('projects', $data);
            $success = "Project created successfully!";
        } catch (Exception $e) {
            $error = "Error creating project: " . $e->getMessage();
        }
    }
    
    if ($action === 'update') {
        try {
            $data = [
                'title' => $_POST['title'],
                'slug' => strtolower(str_replace(' ', '-', $_POST['title'])),
                'description' => $_POST['description'],
                'location' => $_POST['location'],
                'system_size_kw' => $_POST['system_size_kw'],
                'monthly_savings' => $_POST['monthly_savings'],
                'roi_years' => $_POST['roi_years'],
                'project_cost' => $_POST['project_cost'],
                'category_id' => $_POST['category_id'] ?: null,
                'featured_image' => $_POST['featured_image'],
                'completion_date' => $_POST['completion_date'],
                'status' => $_POST['status'],
                'featured' => isset($_POST['featured']) ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $db->update('projects', $data, 'id = ?', [$_POST['project_id']]);
            $success = "Project updated successfully!";
        } catch (Exception $e) {
            $error = "Error updating project: " . $e->getMessage();
        }
    }
    
    if ($action === 'delete') {
        try {
            $db->delete('projects', 'id = ?', [$_POST['project_id']]);
            $success = "Project deleted successfully!";
        } catch (Exception $e) {
            $error = "Error deleting project: " . $e->getMessage();
        }
    }
}

// Get all projects
$projects = $db->fetchAll("SELECT p.*, pc.name as category_name 
                          FROM projects p 
                          LEFT JOIN project_categories pc ON p.category_id = pc.id 
                          ORDER BY p.created_at DESC");

// Get project categories
$categories = $db->fetchAll("SELECT * FROM project_categories ORDER BY name");

// Get specific project for editing
$editProject = null;
if (isset($_GET['edit'])) {
    $editProject = $db->fetch("SELECT * FROM projects WHERE id = ?", [$_GET['edit']]);
}
?>

<?php
$page_title = 'Projects Management';
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
        
        .project-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .badge {
            font-size: 0.8em;
            padding: 0.5em 0.8em;
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
                <div class="admin-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-0">Projects Management</h2>
                            <p class="text-muted mb-0">Manage your solar installation projects</p>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#projectModal">
                            <i class="fas fa-plus me-2"></i>Add New Project
                        </button>
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

                <!-- Projects Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
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
                            <?php foreach ($projects as $project): ?>
                            <tr>
                                <td>
                                    <?php if ($project['featured_image']): ?>
                                        <img src="<?php echo htmlspecialchars($project['featured_image']); ?>" 
                                             class="project-image" alt="Project Image">
                                    <?php else: ?>
                                        <div class="project-image bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($project['title']); ?></strong>
                                    <?php if ($project['category_name']): ?>
                                        <br><small class="text-muted"><?php echo htmlspecialchars($project['category_name']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($project['location']); ?></td>
                                <td><?php echo number_format($project['system_size_kw'], 1); ?> kW</td>
                                <td>
                                    <?php 
                                    $statusColors = [
                                        'completed' => 'success',
                                        'ongoing' => 'warning',
                                        'planned' => 'info'
                                    ];
                                    $color = $statusColors[$project['status']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?php echo $color; ?>">
                                        <?php echo ucfirst($project['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($project['featured']): ?>
                                        <span class="badge bg-warning">Featured</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?edit=<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
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

    <!-- Project Modal -->
    <div class="modal fade" id="projectModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?php echo $editProject ? 'Edit Project' : 'Add New Project'; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="<?php echo $editProject ? 'update' : 'create'; ?>">
                        <?php if ($editProject): ?>
                            <input type="hidden" name="project_id" value="<?php echo $editProject['id']; ?>">
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Project Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?php echo $editProject ? htmlspecialchars($editProject['title']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location *</label>
                                    <input type="text" class="form-control" id="location" name="location" 
                                           value="<?php echo $editProject ? htmlspecialchars($editProject['location']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo $editProject ? htmlspecialchars($editProject['description']) : ''; ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="system_size_kw" class="form-label">System Size (kW) *</label>
                                    <input type="number" step="0.01" class="form-control" id="system_size_kw" name="system_size_kw" 
                                           value="<?php echo $editProject ? $editProject['system_size_kw'] : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="project_cost" class="form-label">Project Cost (₹)</label>
                                    <input type="number" step="0.01" class="form-control" id="project_cost" name="project_cost" 
                                           value="<?php echo $editProject ? $editProject['project_cost'] : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="monthly_savings" class="form-label">Monthly Savings (₹)</label>
                                    <input type="number" step="0.01" class="form-control" id="monthly_savings" name="monthly_savings" 
                                           value="<?php echo $editProject ? $editProject['monthly_savings'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="roi_years" class="form-label">ROI Period (Years)</label>
                                    <input type="number" step="0.1" class="form-control" id="roi_years" name="roi_years" 
                                           value="<?php echo $editProject ? $editProject['roi_years'] : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id']; ?>" 
                                                    <?php echo ($editProject && $editProject['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="completed" <?php echo ($editProject && $editProject['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                        <option value="ongoing" <?php echo ($editProject && $editProject['status'] == 'ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                                        <option value="planned" <?php echo ($editProject && $editProject['status'] == 'planned') ? 'selected' : ''; ?>>Planned</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="completion_date" class="form-label">Completion Date</label>
                                    <input type="date" class="form-control" id="completion_date" name="completion_date" 
                                           value="<?php echo $editProject ? $editProject['completion_date'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">Featured Image URL</label>
                                    <input type="url" class="form-control" id="featured_image" name="featured_image" 
                                           value="<?php echo $editProject ? htmlspecialchars($editProject['featured_image']) : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" 
                                       <?php echo ($editProject && $editProject['featured']) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="featured">
                                    Featured Project
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <?php echo $editProject ? 'Update Project' : 'Create Project'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if ($editProject): ?>
    <script>
        // Show modal if editing
        var projectModal = new bootstrap.Modal(document.getElementById('projectModal'));
        projectModal.show();
    </script>
    <?php endif; ?>
</body>
</html>