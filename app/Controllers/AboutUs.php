<?php

namespace App\Controllers;
use App\Models\Testimonials_model;

class AboutUs extends BaseController
{
    var $testimonials_model;
    function __construct()
    {
        $this->testimonials_model = new Testimonials_model();
    }

    public function index()
    {
        $data = $this->data;
        $data['active_menu'] = 'about-us';
        $data['pageTitle'] = 'About Us';
        $data['testimonial'] = $this->testimonials_model->get_testimonials();
        // echo '<pre>'; print_r($data['testimonial']); die;
        $data['stats'] = [
            ['stat_name' => 'projects_completed', 'stat_value' => '500+', 'stat_label' => 'Projects Completed'],
            ['stat_name' => 'capacity_installed', 'stat_value' => '1000+', 'stat_label' => 'kW Installed'],
            ['stat_name' => 'happy_customers', 'stat_value' => '450+', 'stat_label' => 'Happy Customers'],
            ['stat_name' => 'years_experience', 'stat_value' => '8+', 'stat_label' => 'Years Experience']
        ];
        return view('view_about_us', $data);
    }
}
