<?php

namespace App\Controllers;

class Projects extends BaseController
{
    public function index()
    {
        $data = $this->data;
        $data['active_menu'] = 'projects';
        $data['pageTitle'] = 'Projects';
        return view('view_projects',$data);
    }
}