<?php

namespace App\Controllers;

class Pricing extends BaseController
{
    public function index()
    {
        $data = $this->data;
        $data['active_menu'] = 'pricing';
        $data['pageTitle'] = 'Pricing';
        return view('view_pricing',$data);
    }
}