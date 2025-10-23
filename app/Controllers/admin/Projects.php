<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\Projects_model;

class Projects extends BaseController
{
    var $Projects_model;
    public function __construct()
    {
        $this->Projects_model = new Projects_model();
    }
    public function index()
    {
        $data = $this->data;
        $data['activeMenu'] = 'projects';
        $data['count'] = 1;
        $data['categories'] = $this->Projects_model->project_categories();
        $data['projects'] = $this->Projects_model->get_projects();
        return view('admin/projects/view_projects', $data);
    }

    public function add_project()
    {
        $data = $this->data;
        $data['activeMenu'] = 'projects';
        $data['categories'] = $this->Projects_model->project_categories();
        return view('admin/projects/view_add_project', $data);
    }

    public function save_project()
    {
        $postData = $this->request->getPost();
        $form_status = true;
        $jsonData['status'] = false;

        foreach ($postData as $value) {
            if (empty($value)) {
                $form_status = false;
                $jsonData['message'] = 'Please fill all required fields.';
                $jsonData['msg_class'] = 'alert-danger';
                break;
            }
        }

        if ($form_status) {
            $file = $this->request->getFile('featured_image');
            $featured_image = '';
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $featured_image = $file->getRandomName();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($file->getClientExtension(), $allowedExtensions)) {
                    $uploadPath = FCPATH . 'public/assets/upload_images/projects';
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true); // Create folder if it doesn't exist
                    }
                    // echo $uploadPath; die;
                    $file->move($uploadPath, $featured_image);
                }
            }

            $data = [
                'title' => $postData['title'],
                'url' => randomString(20),
                'slug' => strtolower(str_replace(' ', '-', $postData['title'])),
                'description' => $postData['description'],
                'location' => $postData['location'],
                'system_size_kw' => $postData['system_size_kw'],
                'monthly_savings' => $postData['monthly_savings'],
                'roi_years' => $postData['roi_years'],
                'project_cost' => $postData['project_cost'],
                'category_id' => $postData['category_id'] ?: null,
                'featured_image' => $featured_image,
                'completion_date' => $postData['completion_date'],
                'project_status' => $postData['status'],
                'featured' => isset($postData['featured']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $save = $this->Projects_model->save_project($data);
            if ($save > 0) {
                $jsonData['status'] = true;
                $jsonData['msg_class'] = 'alert-success';
                $jsonData['message'] = 'Project added successfully.';
            } else {
                $jsonData['msg_class'] = 'alert-danger';
                $jsonData['message'] = 'Failed to add project. Please try again.';
            }
        }

        echo json_encode($jsonData);
    }

    public function edit_project($url)
    {
        $data = $this->data;
        $data['activeMenu'] = 'projects';
        $data['categories'] = $this->Projects_model->project_categories();
        $data['project'] = $this->Projects_model->get_project_by_url($url);
        if (empty($data['project'])) {
            return redirect()->to(ADMIN_URL . 'projects');
        }
        return view('admin/projects/view_edit_project', $data);
    }

    public function update_project()
    {
        $postData = $this->request->getPost();
        $form_status = true;
        $jsonData['status'] = false;

        foreach ($postData as $value) {
            if (empty($value) && $value !== '0') {
                $form_status = false;
                $jsonData['msg_class'] = 'alert-danger';
                $jsonData['message'] = 'Please fill all required fields.';
                break;
            }
        }

        if ($form_status) {
            $file = $this->request->getFile('featured_image');
            $featured_image = $postData['existing_image'] ?? '';
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $featured_image = $file->getRandomName();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($file->getClientExtension(), $allowedExtensions)) {
                    $uploadPath = FCPATH . 'public/assets/upload_images/projects';
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true); // Create folder if it doesn't exist
                    }
                    // echo $uploadPath; die;
                    $file->move($uploadPath, $featured_image);
                }
            }

            $data = [
                'title' => $postData['title'],
                'url' => $postData['url'],
                'slug' => strtolower(str_replace(' ', '-', $postData['title'])),
                'description' => $postData['description'],
                'location' => $postData['location'],
                'system_size_kw' => $postData['system_size_kw'],
                'monthly_savings' => $postData['monthly_savings'],
                'roi_years' => $postData['roi_years'],
                'project_cost' => $postData['project_cost'],
                'category_id' => $postData['category_id'] ?: null,
                'featured_image' => $featured_image,
                'completion_date' => $postData['completion_date'],
                'project_status' => $postData['status'],
                'featured' => isset($postData['featured']) ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            if ($featured_image == '') {
                unset($data['featured_image']);
            }

            $update = $this->Projects_model->update_project($data);
            if ($update) {
                $jsonData['status'] = true;
                $jsonData['msg_class'] = 'alert-success';
                $jsonData['message'] = 'Project updated successfully.';
            } else {
                $jsonData['msg_class'] = 'alert-danger';
                $jsonData['message'] = 'No changes made or failed to update project. Please try again.';
            }
        }

        echo json_encode($jsonData);
    }

    public function delete_project()
    {
        $postData = $this->request->getPost();
        $jsonData['status'] = false;

        if (isset($postData['url']) && !empty($postData['url'])) {
            $data = [
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'url' => $postData['url']
            ];
            $delete = $this->Projects_model->update_project($data);
            if ($delete) {
                $jsonData['status'] = true;
                $jsonData['msg_class'] = 'alert-success';
                $jsonData['message'] = 'Project deleted successfully.';
            } else {
                $jsonData['msg_class'] = 'alert-danger';
                $jsonData['message'] = 'Failed to delete project. Please try again.';
            }
        } else {
            $jsonData['msg_class'] = 'alert-danger';
            $jsonData['message'] = 'Invalid request. Please try again.';
        }

        echo json_encode($jsonData);
    }

}
