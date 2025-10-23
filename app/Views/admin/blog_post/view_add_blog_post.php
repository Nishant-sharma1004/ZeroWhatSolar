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
            <h2>Add New Blog Post</h2>
            <a href="<?php echo ADMIN_URL . 'blog-posts'; ?>" class="btn btn-primary">
                <i class="fas fa-minus me-2"></i>View All Blog Posts
            </a>
        </div>

        <div class="alert alert-dismissible" style="display:none">
            <div class="msg"></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <!-- Add/Edit Form -->
        <form id="add_blog" name="add_blog" action="save-blog-post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title *</label>
                        <input type="text" class="form-control" id="title" name="title" value="" required>
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content *</label>
                        <textarea class="form-control" id="content" name="content" rows="15"></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category">
                            <?php foreach ($blog_categories as $row) { ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image" value=""
                            accept=".jpg, .jpeg, .png, .webp, .avif">
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Create Post
                </button>
                <a href="<?php echo ADMIN_URL . 'blog-posts'; ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
    <?php echo view('admin/shared/view_scripts'); ?>
    <script src="<?php echo ASSETS_PATH . 'admin/js/blog.js?rand=' . RAND; ?>"></script>
</body>

</html>