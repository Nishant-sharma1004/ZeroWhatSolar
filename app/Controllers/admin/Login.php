<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\Login_model;
class Login extends BaseController
{
    var $Login_model;
    public function __construct()
    {
        $this->Login_model = new Login_model();
    }
    public function index()
    {
        check_login();
        return view('admin/view_login');
    }

    public function auth()
    {
        $session = session();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $jsonData['status'] = false;
        $jsonData['msg_class'] = 'alert-danger';
        $jsonData['icon'] = 'fa-exclamation-triangle';

        if ($email == '' || $password == '') {
            $jsonData['message'] = 'All fields are required';
            echo json_encode($jsonData);
            exit;
        }

        $data = $this->Login_model->get_user_detail($email);
        if ($data) {
            $pass = $data->password;
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'id' => $data->id,
                    'name' => $data->name,
                    'email' => $data->email,
                    'user_type' => $data->user_type,
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                $jsonData['status'] = true;
                $jsonData['message'] = 'Login Successfully. Please wait...';
                $jsonData['msg_class'] = 'alert-success';
                $jsonData['icon'] = 'fa-check-circle';
                $jsonData['redirect_url'] = base_url('babayaga/AST/admin/dashboard');
            } else {
                $jsonData['message'] = 'Wrong Password';
            }
        } else {
            $jsonData['message'] = 'Email not Found';
        }
        echo json_encode($jsonData);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('babayaga/AST/admin/login'));
    }

}
