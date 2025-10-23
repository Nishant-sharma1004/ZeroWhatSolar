<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = $this->data;
        $data['activeMenu'] = 'dashboard';
        return view('admin/view_dashboard', $data);
    }

    

}
