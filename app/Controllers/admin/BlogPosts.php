<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\Blog_model;

class BlogPosts extends BaseController
{
    protected $Blog_model;

    public function __construct()
    {
        $this->Blog_model = new Blog_model();
    }
    public function index()
    {
        $data = $this->data;
        $data['posts'] = [];
        $data['activeMenu'] = 'blog-posts';
        $data['count'] = 1;
        $data['blog_posts'] = $this->Blog_model->get_blog_posts();
        return view('admin/blog_post/view_blog_posts', $data);
    }

    public function add_blog_post()
    {
        $data = $this->data;
        $data['activeMenu'] = 'blog-posts';
        $data['blog_categories'] = $this->Blog_model->get_blog_categories();
        return view('admin/blog_post/view_add_blog_post', $data);
    }

    public function save_blog_post()
    {
        $postData = $this->request->getPost();
        $form_status = true;
        $jsonData['status'] = false;

        if ($postData['title'] == '' || $postData['content'] == '') {
            $form_status = false;
            $jsonData['message'] = 'Title and content are required!';
            $jsonData['msg_class'] = 'alert-danger';
        }

        if ($form_status) {

            $file = $this->request->getFile('featured_image');
            $newName = '';
            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE && $file->isValid() && !$file->hasMoved()) {
                $uploadPath = FCPATH . 'public/assets/upload_images/blog/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Generate random .webp name
                $newName = pathinfo($file->getRandomName(), PATHINFO_FILENAME) . '.webp';
                $tempPath = $file->getTempName();
                $finalPath = $uploadPath . $newName;

                // Try to create image resource from any format
                $image = @imagecreatefromstring(file_get_contents($tempPath));

                if ($image !== false) {
                    // Save as webp with quality 85
                    imagewebp($image, $finalPath, 85);
                    imagedestroy($image);
                }

                $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $postData['title']));
                $resultCheck = $this->Blog_model->checkBlogPost($slug);
                if ($resultCheck) {
                    $jsonData['message'] = 'Blog post with this title already exists!';
                    $jsonData['msg_class'] = 'alert-danger';
                } else {
                    $formData = [
                        'title' => $postData['title'],
                        'url' => randomString(20),
                        'content' => $postData['content'],
                        'excerpt' => $postData['excerpt'],
                        'category_id' => $postData['category'],
                        'featured_image' => $newName,
                        'post_status' => $postData['status'] ?? 'draft',
                        'slug' => $slug,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'published_at' => date('Y-m-d H:i:s')
                    ];
                    $result = $this->Blog_model->add_blog_post($formData);
                    if ($result > 0) {
                        $jsonData['status'] = true;
                        $jsonData['message'] = 'Blog post added successfully!';
                        $jsonData['msg_class'] = 'alert-success';
                    } else {
                        $jsonData['message'] = 'Something went wrong, please try again!';
                        $jsonData['msg_class'] = 'alert-danger';
                    }
                }
            } else {
                $jsonData['message'] = 'Featured image is required!';
                $jsonData['msg_class'] = 'alert-danger';
            }
        }
        echo json_encode($jsonData);
    }

    public function edit_blog_post($url)
    {
        $data = $this->data;
        $data['activeMenu'] = 'blog-posts';
        $data['post'] = $this->Blog_model->get_blog_post_by_id($url);
        $data['blog_categories'] = $this->Blog_model->get_blog_categories();
        return view('admin/blog_post/view_edit_blog_post', $data);
    }

    public function update_blog_post()
    {
        $data['activeMenu'] = 'blog-posts';
        $postData = $this->request->getPost();
        $form_status = true;
        $jsonData['status'] = false;

        if ($postData['title'] == '' || $postData['content'] == '') {
            $form_status = false;
            $jsonData['message'] = 'Title and content are required!';
            $jsonData['msg_class'] = 'alert-danger';
        }

        if ($form_status) {
            $file = $this->request->getFile('featured_image');
            $newName = '';
            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE && $file->isValid() && !$file->hasMoved()) {
                $uploadPath = FCPATH . 'public/assets/upload_images/blog/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Generate random .webp name
                $newName = pathinfo($file->getRandomName(), PATHINFO_FILENAME) . '.webp';
                $tempPath = $file->getTempName();
                $finalPath = $uploadPath . $newName;

                // Try to create image resource from any format
                $image = @imagecreatefromstring(file_get_contents($tempPath));

                if ($image !== false) {
                    // Save as webp with quality 85
                    imagewebp($image, $finalPath, 85);
                    imagedestroy($image);
                }
            }

            $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $postData['title']));
            $formData = [
                'title' => $postData['title'],
                'url' => $postData['url'],
                'content' => $postData['content'],
                'excerpt' => $postData['excerpt'],
                'category_id' => $postData['category'],
                'featured_image' => $newName,
                'post_status' => $postData['status'] ?? 'draft',
                'slug' => $slug,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($newName == '') {
                unset($formData['featured_image']);
            }
            $result = $this->Blog_model->update_blog_post($formData);
            if ($result) {
                $jsonData['status'] = true;
                $jsonData['message'] = 'Blog post updated successfully!';
                $jsonData['msg_class'] = 'alert-success';
            } else {
                $jsonData['message'] = 'Something went wrong, please try again!';
                $jsonData['msg_class'] = 'alert-danger';
            }
        }
        echo json_encode($jsonData);
    }

    public function delete_post()
    {
        $postData = $this->request->getPost();
        if (isset($postData['url']) && $postData['url'] != '') {
            $postData = [
                'url' => $postData['url'],
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $result = $this->Blog_model->update_blog_post($postData);
            if ($result) {
                $jsonData['status'] = true;
                $jsonData['message'] = 'Blog post deleted successfully!';
                $jsonData['msg_class'] = 'alert-success';
            } else {
                $jsonData['message'] = 'Something went wrong, please try again!';
                $jsonData['msg_class'] = 'alert-danger';
            }
        } else {
            $jsonData['message'] = 'Invalid request!';
            $jsonData['msg_class'] = 'alert-danger';
        }
        echo json_encode($jsonData);
    }
}