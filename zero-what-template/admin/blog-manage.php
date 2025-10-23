<?php
require_once 'auth.php';
checkAdminAuth();
require_once '../config/database.php';

$db = Database::getInstance()->getConnection();
$success = $error = '';

// Handle form submissions
if ($_POST) {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add' || $action === 'edit') {
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $excerpt = trim($_POST['excerpt'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $featured_image = trim($_POST['featured_image'] ?? '');
        $status = $_POST['status'] ?? 'draft';
        $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $title));
        
        if (empty($title) || empty($content)) {
            $error = 'Title and content are required!';
        } else {
            try {
                if ($action === 'add') {
                    $stmt = $db->prepare("
                        INSERT INTO blog_posts (title, slug, content, excerpt, category, featured_image, status, created_at, updated_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
                    ");
                    $stmt->execute([$title, $slug, $content, $excerpt, $category, $featured_image, $status]);
                    $success = 'Blog post added successfully!';
                } else {
                    $id = $_POST['id'] ?? 0;
                    $stmt = $db->prepare("
                        UPDATE blog_posts 
                        SET title=?, slug=?, content=?, excerpt=?, category=?, featured_image=?, status=?, updated_at=NOW() 
                        WHERE id=?
                    ");
                    $stmt->execute([$title, $slug, $content, $excerpt, $category, $featured_image, $status, $id]);
                    $success = 'Blog post updated successfully!';
                }
            } catch (Exception $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        }
    }
    
    if ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $db->prepare("DELETE FROM blog_posts WHERE id = ?");
            $stmt->execute([$id]);
            $success = 'Blog post deleted successfully!';
        } catch (Exception $e) {
            $error = 'Error deleting blog post: ' . $e->getMessage();
        }
    }
}

// Get blog posts
$stmt = $db->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle edit mode
$editPost = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->execute([$editId]);
    $editPost = $stmt->fetch(PDO::FETCH_ASSOC);
}

$isAddMode = isset($_GET['action']) && $_GET['action'] === 'add';
$isEditMode = !empty($editPost);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management - Zero What Solar Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1E3A8A;
            --accent-blue: #3B82F6;
            --sidebar-width: 250px;
        }
        
        body { background-color: #f8f9fa; }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-blue), var(--accent-blue));
            color: white;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1.5rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Blog Management</h2>
            <?php if (!$isAddMode && !$isEditMode): ?>
                <a href="?action=add" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Post
                </a>
            <?php endif; ?>
        </div>
        
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo htmlspecialchars($success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($isAddMode || $isEditMode): ?>
            <!-- Add/Edit Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        <?php echo $isEditMode ? 'Edit Blog Post' : 'Add New Blog Post'; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="<?php echo $isEditMode ? 'edit' : 'add'; ?>">
                        <?php if ($isEditMode): ?>
                            <input type="hidden" name="id" value="<?php echo $editPost['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?php echo htmlspecialchars($editPost['title'] ?? ''); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Excerpt</label>
                                    <textarea class="form-control" id="excerpt" name="excerpt" rows="3"><?php echo htmlspecialchars($editPost['excerpt'] ?? ''); ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="content" class="form-label">Content *</label>
                                    <textarea class="form-control" id="content" name="content" rows="15"><?php echo htmlspecialchars($editPost['content'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="draft" <?php echo ($editPost['status'] ?? '') === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                        <option value="published" <?php echo ($editPost['status'] ?? '') === 'published' ? 'selected' : ''; ?>>Published</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-control" id="category" name="category">
                                        <option value="Solar Installation" <?php echo ($editPost['category'] ?? '') === 'Solar Installation' ? 'selected' : ''; ?>>Solar Installation</option>
                                        <option value="Government Policy" <?php echo ($editPost['category'] ?? '') === 'Government Policy' ? 'selected' : ''; ?>>Government Policy</option>
                                        <option value="Maintenance Tips" <?php echo ($editPost['category'] ?? '') === 'Maintenance Tips' ? 'selected' : ''; ?>>Maintenance Tips</option>
                                        <option value="Cost Analysis" <?php echo ($editPost['category'] ?? '') === 'Cost Analysis' ? 'selected' : ''; ?>>Cost Analysis</option>
                                        <option value="Technology" <?php echo ($editPost['category'] ?? '') === 'Technology' ? 'selected' : ''; ?>>Technology</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">Featured Image URL</label>
                                    <input type="url" class="form-control" id="featured_image" name="featured_image" 
                                           value="<?php echo htmlspecialchars($editPost['featured_image'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                <?php echo $isEditMode ? 'Update Post' : 'Create Post'; ?>
                            </button>
                            <a href="blog-manage.php" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!-- Posts List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">All Blog Posts (<?php echo count($posts); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($posts)): ?>
                        <p class="text-muted text-center py-4">No blog posts found. <a href="?action=add">Create your first post</a>.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($posts as $post): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                                                <?php if ($post['excerpt']): ?>
                                                    <br><small class="text-muted"><?php echo htmlspecialchars(substr($post['excerpt'], 0, 100)); ?>...</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($post['category_id']): ?>
                                                    <span class="badge bg-secondary">Category ID: <?php echo htmlspecialchars($post['category_id']); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-light text-dark">No Category</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo $post['status'] === 'published' ? 'bg-success' : 'bg-warning'; ?>">
                                                    <?php echo ucfirst($post['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($post['created_at'])); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="?edit=<?php echo $post['id']; ?>" class="btn btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            onclick="deletePost(<?php echo $post['id']; ?>, '<?php echo htmlspecialchars($post['title']); ?>')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
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
                    <p>Are you sure you want to delete this blog post?</p>
                    <p><strong id="deleteTitle"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" id="deleteId">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deletePost(id, title) {
            document.getElementById('deleteId').value = id;
            document.getElementById('deleteTitle').textContent = title;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
</body>
</html>