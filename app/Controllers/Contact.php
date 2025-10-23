<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index()
    {
        $data = $this->data;
        $getData = $this->request->getGet();
        $data['status'] = $getData['status'] ?? '';
        $data['message'] = $getData['msg'] ?? '';
        $data['active_menu'] = 'contact';
        $data['pageTitle'] = 'Contact Us';
        return view('view_contact', $data);
    }
}