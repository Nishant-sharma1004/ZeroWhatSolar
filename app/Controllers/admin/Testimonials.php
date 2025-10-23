<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\Testimonials_model;

class Testimonials extends BaseController
{
    var $Testimonials_model;
    public function __construct()
    {
        $this->Testimonials_model = new Testimonials_model();
    }
    public function index()
    {
        $data = $this->data;
        $data['activeMenu'] = 'testimonials';
        $data['count'] = 1;
        $testimonials = $this->Testimonials_model->get_testimonials();
        $data['testimonials'] = $testimonials;
        $data['totalTestimonials'] = count($testimonials);
        $data['approvedTestimonials'] = count(array_filter($testimonials, function ($t) {
            return $t->testimonials_status === 'approved';
        }));
        $data['pendingTestimonials'] = count(array_filter($testimonials, function ($t) {
            return $t->testimonials_status === 'pending';
        }));
        $data['featuredTestimonials'] = count(array_filter($testimonials, function ($t) {
            return $t->featured == 1;
        }));
        return view('admin/testimonials/view_testimonials', $data);
    }

    public function add_testimonials()
    {
        $data = $this->data;
        $data['activeMenu'] = 'testimonials';
        return view('admin/testimonials/view_add_testimonials', $data);
    }

    public function save_testimonials()
    {
        $postData = $this->request->getPost();
        $form_status = true;
        $jsonData['status'] = false;

        if ($postData['customer_name'] == '' || $postData['location'] == '' || $postData['testimonial_text'] == '' || $postData['rating'] == '') {
            $form_status = false;
            $jsonData['msg_class'] = 'alert-danger';
            $jsonData['message'] = 'Please fill all required fields.';
        }
        if ($form_status) {
            $file = $this->request->getFile('customer_image');
            $customer_image = '';
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $customer_image = $file->getRandomName();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($file->getClientExtension(), $allowedExtensions)) {
                    $uploadPath = FCPATH . 'public/assets/upload_images/testimonials';
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true); // Create folder if it doesn't exist
                    }
                    // echo $uploadPath; die;
                    $file->move($uploadPath, $customer_image);
                }
            }

            $data = [
                'customer_name' => $postData['customer_name'],
                'location' => $postData['location'],
                'testimonial_text' => $postData['testimonial_text'],
                'url' => randomString(20),
                'rating' => $postData['rating'],
                'system_size_kw' => $postData['system_size_kw'] != '' ? $postData['system_size_kw'] : null,
                'savings_amount' => $postData['savings_amount'] != '' ? $postData['savings_amount'] : null,
                'customer_image' => $customer_image,
                'featured' => isset($postData['featured']) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $result = $this->Testimonials_model->save_testimonial($data);
            if ($result > 0) {
                $jsonData['status'] = true;
                $jsonData['msg_class'] = 'alert-success';
                $jsonData['message'] = 'Testimonial added successfully.';
            } else {
                $jsonData['msg_class'] = 'alert-danger';
                $jsonData['message'] = 'Something went wrong. Please try again.';
            }
        }
        echo json_encode($jsonData);
    }

    public function edit_testimonials($url)
    {
        $data = $this->data;
        $data['activeMenu'] = 'testimonials';
        $data['testimonial'] = $this->Testimonials_model->get_testimonial_detail($url);
        return view('admin/testimonials/view_edit_testimonials', $data);
    }

    public function update_testimonials()
    {
        $postData = $this->request->getPost();
        $form_status = true;
        $jsonData['status'] = false;

        if ($postData['customer_name'] == '' || $postData['location'] == '' || $postData['testimonial_text'] == '' || $postData['rating'] == '') {
            $form_status = false;
            $jsonData['msg_class'] = 'alert-danger';
            $jsonData['message'] = 'Please fill all required fields.';
        }
        if ($form_status) {
            $file = $this->request->getFile('customer_image');
            $customer_image = '';
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $customer_image = $file->getRandomName();
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($file->getClientExtension(), $allowedExtensions)) {
                    $uploadPath = FCPATH . 'public/assets/upload_images/testimonials';
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true); // Create folder if it doesn't exist
                    }
                    // echo $uploadPath; die;
                    $file->move($uploadPath, $customer_image);
                }
            }

            $data = [
                'url' => $postData['url'],
                'customer_name' => $postData['customer_name'],
                'location' => $postData['location'],
                'testimonial_text' => $postData['testimonial_text'],
                'rating' => $postData['rating'],
                'system_size_kw' => $postData['system_size_kw'] != '' ? $postData['system_size_kw'] : null,
                'savings_amount' => $postData['savings_amount'] != '' ? $postData['savings_amount'] : null,
                'customer_image' => $customer_image,
                'featured' => isset($postData['featured']) ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($customer_image == '') {
                unset($data['customer_image']);
            }

            $result = $this->Testimonials_model->update_testimonial($data);
            if ($result > 0) {
                $jsonData['status'] = true;
                $jsonData['msg_class'] = 'alert-success';
                $jsonData['message'] = 'Testimonial added successfully.';
            } else {
                $jsonData['msg_class'] = 'alert-danger';
                $jsonData['message'] = 'Something went wrong. Please try again.';
            }
        }
        echo json_encode($jsonData);
    }

public function delete_testimonials()
    {
        $postData = $this->request->getPost();
        $jsonData['status'] = false;

        if (isset($postData['url']) && $postData['url'] != '') {
            $data = [
                'url' => $postData['url'],
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $result = $this->Testimonials_model->update_testimonial($data);
            if ($result > 0) {
                $jsonData['status'] = true;
                $jsonData['msg_class'] = 'alert-success';
                $jsonData['message'] = 'Testimonial deleted successfully.';
            } else {
                $jsonData['msg_class'] = 'alert-danger';
                $jsonData['message'] = 'Something went wrong. Please try again.';
            }
        } else {
            $jsonData['msg_class'] = 'alert-danger';
            $jsonData['message'] = 'Invalid request. Please try again.';
        }
        echo json_encode($jsonData);
    }
}
