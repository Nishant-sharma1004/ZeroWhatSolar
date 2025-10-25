<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\Contact_model;

class ContactLeads extends BaseController
{
    var $Contact_model;
    function __construct()
    {
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

    public function deleteContact()
    {
        $postData = $this->request->getPost();
        if (isset($postData['id']) && $postData['id'] != '') {
            $postData = [
                'id' => $postData['id'],
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $result = $this->Contact_model->update_contact_lead($postData);
            if ($result) {
                $jsonData['status'] = true;
                $jsonData['message'] = 'Contact submission deleted successfully!';
                $jsonData['msg_class'] = 'alert-success';
            } else {
                $jsonData['message'] = 'Something went wrong, please try again!';
                $jsonData['msg_class'] = 'alert-danger';
            }
        } else {
            $jsonData['message'] = 'Invalid request!';
            $jsonData['msg_class'] = 'alert-danger';
        }
        echo json_encode($jsonData);
    }
}
