<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\Blog_model;
use App\Models\admin\Projects_model;
use App\Models\admin\Testimonials_model;
use App\Models\admin\Contact_model;

class Dashboard extends BaseController
{
    var $Blog_model;
    var $Projects_model;
    var $Testimonials_model;
    var $Contact_model;
    function __construct(){
        $this->Blog_model = new Blog_model();
        $this->Projects_model = new Projects_model();
        $this->Testimonials_model = new Testimonials_model();
        $this->Contact_model = new Contact_model();
    }

    public function index()
    {
        $data = $this->data;
        $data['activeMenu'] = 'dashboard';
        $data['blogCount'] = $this->Blog_model->get_blog_count();
        $data['projectCount'] = $this->Projects_model->get_project_count();
        $data['testimonialCount'] = $this->Testimonials_model->get_testimonial_count();
        $data['leadCount'] = $this->Contact_model->get_monthly_contact();
        $data['recentContacts'] = $this->Contact_model->get_contact_leads(['limit' => 5]);
        return view('admin/view_dashboard', $data);
    }


    

}
