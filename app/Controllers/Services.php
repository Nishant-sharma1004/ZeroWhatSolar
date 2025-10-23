<?php

namespace App\Controllers;

class Services extends BaseController
{
    public function index()
    {
        $data = $this->data;
        $data['active_menu'] = 'services';
        $data['pageTitle'] = 'Our Services';
        $data['services'] = [];
        $data['settings'] = [
            'services_title' => 'Complete Solar Solutions for Every Need',
            'services_subtitle' => 'From residential rooftops to large industrial installations, we provide end-to-end solar solutions with guaranteed performance and maximum savings.'
        ];
        return view('view_services', $data);
    }
}