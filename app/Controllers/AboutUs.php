<?php

namespace App\Controllers;

class AboutUs extends BaseController
{
    public function index()
    {
        $data = $this->data;
        $data['active_menu'] = 'about-us';
        $data['pageTitle'] = 'About Us';
        $data['testimonial'] = [];
        $data['stats'] = [
            ['stat_name' => 'projects_completed', 'stat_value' => '500+', 'stat_label' => 'Projects Completed'],
            ['stat_name' => 'capacity_installed', 'stat_value' => '1000+', 'stat_label' => 'kW Installed'],
            ['stat_name' => 'happy_customers', 'stat_value' => '450+', 'stat_label' => 'Happy Customers'],
            ['stat_name' => 'years_experience', 'stat_value' => '8+', 'stat_label' => 'Years Experience']
        ];
        return view('view_about_us', $data);
    }
}
