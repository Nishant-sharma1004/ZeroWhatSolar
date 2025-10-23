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
            <h2>Blog Management</h2>
            <a href="<?php echo ADMIN_URL . 'add-blog-post' ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Post
            </a>
        </div>

        <!-- Posts List -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">All Blog Posts (<?php echo count($blog_posts); ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($blog_posts)) { ?>
                    <p class="text-muted text-center py-4">No blog posts found. <a
                            href="<?php echo ADMIN_URL . 'add-blog-post'; ?>">Create your first
                            post</a>.</p>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($blog_posts as $post) { ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td>
                                            <strong><?php echo $post->title; ?></strong>
                                            <?php if ($post->excerpt) { ?>
                                                <br><small
                                                    class="text-muted"><?php echo substr($post->excerpt, 0, 100); ?>...</small>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($post->category) { ?>
                                                <span class="badge bg-secondary">Category ID:
                                                    <?php echo $post->category; ?></span>
                                            <?php } else { ?>
                                                <span class="badge bg-light text-dark">No Category</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <span
                                                class="badge <?php echo $post->post_status === 'published' ? 'bg-success' : 'bg-warning'; ?>">
                                                <?php echo ucfirst($post->post_status); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M j, Y', strtotime($post->created_at)); ?></td>
                                        <td>
                                            <a href="<?php echo ADMIN_URL . 'edit-blog-post/' . $post->url; ?>"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="d-inline">
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="deletePost('<?php echo $post->url; ?>', '<?php echo $post->title; ?>')">
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
                    <p>Are you sure you want to delete this blog post?</p>
                    <p><strong id="deleteTitle"></strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form style="display: inline;" action="delete-post" id="delete_post">
                        <input type="hidden" name="url" id="deleteUrl">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ASSETS_PATH . 'admin/js/blog.js?rand=' . RAND; ?>"></script>
</body>

</html>