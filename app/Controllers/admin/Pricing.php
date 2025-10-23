<?php

namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\admin\Pricing_model;

class Pricing extends BaseController
{
    var $Pricing_model;
    function __construct()
    {
        $this->Pricing_model = new Pricing_model();
    }
    public function index()
    {
        $data = $this->data;
        $data['activeMenu'] = 'pricing-packages';

        $site_settings = $this->Pricing_model->get_settings();
        foreach ($site_settings as $setting) {
            // Get current pricing settings
            $data['currentPricing'][$setting->setting_key] = $setting->setting_value;
        }

        return view('admin/view_pricing', $data);
    }

    public function update_pricing()
    {
        $postData = $this->request->getPost();
        $update = $insert = '';
        $jsonData = [
            'status' => false,
            'msg_class' => 'alert-danger',
            'message' => 'Something went wrong. Please try again!'
        ];
        $pricing_data = [
            // Residential pricing
            'residential_base_price' => $postData['residential_base_price'] ?? 0,
            'residential_price_per_kw' => $postData['residential_price_per_kw'] ?? 0,
            'residential_subsidy_percentage' => $postData['residential_subsidy_percentage'] ?? 0,
            // Commercial pricing
            'commercial_base_price' => $postData['commercial_base_price'] ?? 0,
            'commercial_price_per_kw' => $postData['commercial_price_per_kw'] ?? 0,
            'commercial_subsidy_percentage' => $postData['commercial_subsidy_percentage'] ?? 0,
            // General settings
            'installation_cost_percentage' => $postData['installation_cost_percentage'] ?? 15,
            'maintenance_annual_cost' => $postData['maintenance_annual_cost'] ?? 5000,
            'warranty_years' => $postData['warranty_years'] ?? 25,
            'payback_period_years' => $postData['payback_period_years'] ?? 7
        ];

        foreach ($pricing_data as $key => $value) {
            // Check if setting exists
            $existingSetting = $this->Pricing_model->get_settings($key);
            if ($existingSetting) {
                // Update existing setting
                $data = [
                    'setting_value' => $value,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'setting_key' => $key
                ];
                // die;
                $update = $this->Pricing_model->update_settings($data);
            } else {
                // Insert new setting
                $data = [
                    'setting_key' => $key,
                    'setting_value' => $value,
                    'setting_type' => 'text',
                    'description' => ucwords(str_replace('_', ' ', $key))
                ];
                $insert = $this->Pricing_model->insert_settings($data);
            }

            if ($update || $insert > 0) {
                $jsonData = [
                    'status' => true,
                    'msg_class' => 'alert-success',
                    'message' => 'Settings updated successfully.'
                ];
            }
        }
        echo json_encode($jsonData);
    }
}
