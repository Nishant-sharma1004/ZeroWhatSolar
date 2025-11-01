<?php

namespace App\Controllers;
use App\Models\Project_model;

class Projects extends BaseController
{
    var $Project_model;
    function __construct(){
        $this->Project_model = new Project_model();
    }
    public function index()
    {
        $data = $this->data;
        $data['active_menu'] = 'projects';
        $data['pageTitle'] = 'Projects';
        $data['projects'] = $this->Project_model->getAllProjects();
        return view('view_projects',$data);
    }
}