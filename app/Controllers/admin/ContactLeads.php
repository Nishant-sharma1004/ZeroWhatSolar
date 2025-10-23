<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\Contact_model;

class ContactLeads extends BaseController
{
    var $Contact_model;
    function __construct(){
        $this->Contact_model = new Contact_model();
    }
    public function index()
    {
        $data = $this->data;
        $data['activeMenu'] = 'contact-leads';
        $getData = $this->request->getGet();
        $data['contacts'] = $this->Contact_model->get_contact_leads($getData);
        $data['totalCount'] = count($this->Contact_model->get_contact_leads());
        $data['unreadCount'] = count($this->Contact_model->get_unread_contact());
        $data['todayCount'] = count($this->Contact_model->get_todays_contact());
        $data['filter'] = $getData['filter'] ?? 'all';
        $data['search'] = $getData['search'] ?? '';
        return view('admin/view_contact_leads', $data);
    }
}
