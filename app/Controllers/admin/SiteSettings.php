<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\Setting_model;

class SiteSettings extends BaseController
{
    var $Setting_model;
    function __construct()
    {
        $this->Setting_model = new Setting_model();
    }

    public function index()
    {
        $data = $this->data;
        $data['activeMenu'] = 'site-settings';
        $site_settings = $this->Setting_model->get_site_settings();
        foreach ($site_settings as $setting) {
            $data['currentSettings'][$setting->setting_key] = $setting->setting_value;
        }
        return view('admin/view_settings', $data);
    }

    public function update_settings()
    {
        $postData = $this->request->getPost();
        $jsonData = [
            'status' => false,
            'msg_class' => 'alert-danger',
            'message' => 'Something went wrong. Please try again!'
        ];
        $settings = [
            'company_name' => $postData['company_name'] ?? '',
            'company_tagline' => $postData['company_tagline'] ?? '',
            'contact_email' => $postData['contact_email'] ?? '',
            'contact_phone' => $postData['contact_phone'] ?? '',
            'whatsapp_number' => $postData['whatsapp_number'] ?? '',
            'office_address' => $postData['office_address'] ?? '',
            'gst_number' => $postData['gst_number'] ?? '',
            'facebook_url' => $postData['facebook_url'] ?? '',
            'twitter_url' => $postData['twitter_url'] ?? '',
            'instagram_url' => $postData['instagram_url'] ?? '',
            'linkedin_url' => $postData['linkedin_url'] ?? '',
            'youtube_url' => $postData['youtube_url'] ?? '',
            'google_analytics_id' => $postData['google_analytics_id'] ?? '',
            'meta_description' => $postData['meta_description'] ?? '',
            'meta_keywords' => $postData['meta_keywords'] ?? ''
        ];

        foreach ($settings as $key => $value) {
            // Check if setting exists
            $existingSetting = $this->Setting_model->get_site_settings($key);
            if ($existingSetting) {
                // Update existing setting
                $data = [
                    'setting_value' => $value,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'setting_key' => $key
                ];
                // die;
                $update = $this->Setting_model->update_settings($data);
                if ($update) {
                    $jsonData = [
                        'status' => true,
                        'msg_class' => 'alert-success',
                        'message' => 'Site setting updated successfully.'
                    ];
                }
            } else {
                // Insert new setting
                $data = [
                    'setting_key' => $key,
                    'setting_value' => $value,
                    'setting_type' => 'text',
                    'description' => ucwords(str_replace('_', ' ', $key))
                ];
                $insert = $this->Setting_model->insert_settings($data);
                if ($insert > 0) {
                    $jsonData = [
                        'status' => true,
                        'msg_class' => 'alert-success',
                        'message' => 'Site setting added successfully.'
                    ];
                }
            }
        }
        echo json_encode($jsonData);
    }
}
