<?php

namespace App\Controllers;

class Subsidy extends BaseController
{
    public function index()
    {
        $data = $this->data;
        $data['active_menu'] = 'subsidy-info';
        $data['pageTitle'] = 'Subsidy Information';
        return view('view_subsidy_info',$data);
    }
}