<?php

namespace App\Controllers;
use App\Models\Dashboard_model;

class Dashboard extends BaseController
{
    var $Dashboard_model;
    function __construct()
    {
        $this->Dashboard_model = new Dashboard_model();
    }
    public function index()
    {
        $data = $this->data;
        $data['active_menu'] = 'home';
        $data['pageTitle'] = 'Dashboard';
        $data['blog_posts'] = $this->Dashboard_model->get_blog();
        $data['testimonials'] = $this->Dashboard_model->get_testimonials();
        $data['stats'] = [
            ['stat_name' => 'customers', 'stat_value' => '500+', 'stat_label' => 'Happy Customers'],
            ['stat_name' => 'installations', 'stat_value' => '1000+', 'stat_label' => 'kW Installed'],
            ['stat_name' => 'savings', 'stat_value' => '₹2Cr+', 'stat_label' => 'Savings Generated'],
            ['stat_name' => 'experience', 'stat_value' => '5+', 'stat_label' => 'Years Experience']
        ];
        return view('view_dashboard', $data);
    }

    public function processForm()
    {
        $data = $this->data;
        $form_status = true;
        $post = $this->request->getPost();
        $lead_score = 0;
        $jsonData = [
            'status' => false,
            'message' => 'Something went wrong. Please try again.',
            'msg_class' => 'alert-danger'
        ];

        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $form_status = false;
            $jsonData['message'] = 'Please enter a valid email address.';
            $jsonData['msg_class'] = 'alert-danger';
        }

        // Validate phone number (10 digits)
        if (!preg_match('/^[0-9]{10}$/', $post['phone'])) {
            $form_status = false;
            $jsonData['message'] = 'Please enter a valid 10-digit phone number.';
            $jsonData['msg_class'] = 'alert-danger';
        }


        if ($form_status) {

            $postData = [
                'name' => filter_var(trim($post["name"]), FILTER_SANITIZE_STRING),
                'email' => filter_var(trim($post["email"]), FILTER_SANITIZE_EMAIL),
                'phone' => filter_var(trim($post["phone"]), FILTER_SANITIZE_STRING),
                'property_type' => filter_var(trim($post["property_type"] ?? ''), FILTER_SANITIZE_STRING),
                'monthly_bill' => filter_var(trim($post["monthly_bill"] ?? ''), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'address' => filter_var(trim($post["address"] ?? ''), FILTER_SANITIZE_STRING),
                'message' => filter_var(trim($post["message"] ?? ''), FILTER_SANITIZE_STRING),
                'whatsapp_updates' => isset($post["whatsapp_updates"]) ? 1 : 0,
                'contact_status' => 'unread',
                'source' => 'website',
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];


            // Calculate lead score
            if ($postData["property_type"])
                $lead_score += 2;
            if ($postData["monthly_bill"])
                $lead_score += 3;
            if ($postData["address"])
                $lead_score += 1;
            if ($postData["message"])
                $lead_score += 1;

            $postData['lead_score'] = $lead_score;

            $result = $this->Dashboard_model->insertContact($postData);
            if ($result > 0) {
                $jsonData = [
                    'status' => true,
                    'message' => "<strong>🎉 Thank You!</strong> Your inquiry has been submitted successfully. Our solar experts will contact you within 2 hours with a detailed proposal.",
                    'msg_class' => 'alert-success'
                ];
                $email_status = $this->enquieryEmail($postData, $lead_score);
            }
        }

        echo json_encode($jsonData);
    }

    function enquieryEmail($postData, $lead_score)
    {
        return 'test';
        $email = \Config\Services::email();
        $recipient = "contact@zerowhatsolar.in";
        $subject = "🌟 New Solar Inquiry from " . $postData['name'] . " - Zero What Solar";

        $emailData = [];
        if ($lead_score >= 5) {
            $emailData['priority_text'] = "🔥 HIGH PRIORITY LEAD - Contact within 2 hours";
            $emailData['priority_color'] = "#d32f2f";
        } elseif ($lead_score >= 3) {
            $emailData['priority_text'] = "⚡ MEDIUM PRIORITY LEAD - Contact within 24 hours";
            $emailData['priority_color'] = "#f57c00";
        } else {
            $emailData['priority_text'] = "🕓 LOW PRIORITY LEAD - Review before contacting";
            $emailData['priority_color'] = "#777";
        }

        if ($postData['property_type']) {
            $emailData['priority_text'] = $postData['property_type'];
        }

        if ($postData['monthly_bill']) {
            $emailData['monthly_bill'] = $postData['monthly_bill'];
        }

        if ($postData['address']) {
            $emailData['address'] = $postData['address'];
        }

        if ($postData['message']) {
            $emailData['message'] = $postData['message'];
        }

        $emailData['name'] = $postData['name'];
        $emailData['email'] = $postData['email'];
        $emailData['phone'] = $postData['phone'];
        $emailData['whatsapp_updates'] = $postData['whatsapp_updates'];
        $emailData['lead_score'] = $lead_score;
        // echo '<pre>'; print_r($emailData); die;
        $email_temp = parseTemplate(view('emails/view_enquiery_mail', $emailData), $emailData);

        $email->setTo($postData['email']);
        $email->setFrom(FROM_MAIL, FROM_NAME);
        $email->setSubject($subject);
        $email->setMessage($email_temp);

        if ($email->send()) {
            return "Email successfully sent!";
        } else {
            // For debugging errors
            $data = $email->printDebugger(['headers']);
            return $data;
        }
    }

}
