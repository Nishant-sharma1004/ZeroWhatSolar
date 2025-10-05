<?php
/**
 * Vercel Serverless Function for Solar Calculator
 * This file should be placed in /api/ directory for Vercel deployment
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Include database configuration
require_once '../config/database.php';

try {
    // Get form data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        $input = $_POST;
    }
    
    // Validate required fields
    $required_fields = ['customer_name', 'email', 'phone', 'monthly_bill', 'property_type'];
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            throw new Exception("Field '$field' is required");
        }
    }
    
    // Sanitize input
    $monthly_bill = filter_var($input['monthly_bill'], FILTER_VALIDATE_FLOAT);
    $rooftop_area = isset($input['rooftop_area']) ? filter_var($input['rooftop_area'], FILTER_VALIDATE_FLOAT) : null;
    
    if (!$monthly_bill || $monthly_bill <= 0) {
        throw new Exception('Invalid monthly bill amount');
    }
    
    // Solar calculation logic
    $units_per_month = $monthly_bill / 7; // Assuming ₹7 per unit average
    $system_size_kw = ceil($units_per_month / 120); // 120 units per kW per month average
    
    // Ensure minimum 1kW system
    if ($system_size_kw < 1) $system_size_kw = 1;
    
    // Cost calculations
    $base_price_per_kw = 65000; // ₹65,000 per kW
    $total_cost = $system_size_kw * $base_price_per_kw;
    
    // Government subsidy calculation
    $subsidy = 0;
    if ($system_size_kw <= 3) {
        $subsidy = $system_size_kw * 18000; // ₹18,000 per kW for first 3kW
    } else {
        $subsidy = (3 * 18000) + (($system_size_kw - 3) * 9000); // ₹9,000 per kW beyond 3kW
    }
    
    // Cap subsidy at ₹78,000
    if ($subsidy > 78000) $subsidy = 78000;
    
    $final_cost = $total_cost - $subsidy;
    
    // Monthly savings calculation
    $monthly_generation = $system_size_kw * 120; // units per month
    $monthly_savings = min($monthly_generation * 7, $monthly_bill * 0.9); // Max 90% savings
    
    // Payback period
    $payback_period = $final_cost / ($monthly_savings * 12);
    
    // Calculate lead score
    $lead_score = 0;
    if ($monthly_bill > 5000) $lead_score += 40;
    elseif ($monthly_bill > 3000) $lead_score += 30;
    elseif ($monthly_bill > 1500) $lead_score += 20;
    
    if (in_array($input['property_type'], ['independent_house', 'villa'])) $lead_score += 25;
    if ($rooftop_area && $rooftop_area >= 200) $lead_score += 15;
    if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) $lead_score += 10;
    if (!empty($input['phone'])) $lead_score += 10;
    
    // Prepare data for database
    $data = [
        'customer_name' => filter_var($input['customer_name'], FILTER_SANITIZE_STRING),
        'email' => filter_var($input['email'], FILTER_VALIDATE_EMAIL),
        'phone' => filter_var($input['phone'], FILTER_SANITIZE_STRING),
        'monthly_bill' => $monthly_bill,
        'property_type' => filter_var($input['property_type'], FILTER_SANITIZE_STRING),
        'rooftop_area' => $rooftop_area,
        'location' => isset($input['location']) ? filter_var($input['location'], FILTER_SANITIZE_STRING) : 'Jaipur',
        'system_size_kw' => $system_size_kw,
        'estimated_cost' => $final_cost,
        'government_subsidy' => $subsidy,
        'monthly_savings' => $monthly_savings,
        'payback_period' => $payback_period,
        'lead_score' => $lead_score,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? ''
    ];
    
    if (!$data['email']) {
        throw new Exception('Invalid email address');
    }
    
    // Insert into database
    $db = getDBInstance();
    $id = $db->insert('calculator_results', $data);
    
    // Prepare response
    $response = [
        'success' => true,
        'calculation_id' => $id,
        'results' => [
            'system_size_kw' => $system_size_kw,
            'total_cost' => $total_cost,
            'government_subsidy' => $subsidy,
            'final_cost' => $final_cost,
            'monthly_savings' => round($monthly_savings),
            'yearly_savings' => round($monthly_savings * 12),
            'payback_period' => round($payback_period, 1),
            'monthly_generation' => $monthly_generation,
            'lead_score' => $lead_score
        ],
        'message' => 'Solar calculation completed successfully!'
    ];
    
    // Send notification email for high-score leads
    if ($lead_score >= 50) {
        try {
            $to = 'sales@zerowhatsolar.in';
            $subject = 'High-Score Solar Lead - ' . $data['customer_name'];
            $message = "High-priority solar lead received:\n\n";
            $message .= "Name: " . $data['customer_name'] . "\n";
            $message .= "Email: " . $data['email'] . "\n";
            $message .= "Phone: " . $data['phone'] . "\n";
            $message .= "Monthly Bill: ₹" . number_format($monthly_bill) . "\n";
            $message .= "System Size: " . $system_size_kw . " kW\n";
            $message .= "Estimated Cost: ₹" . number_format($final_cost) . "\n";
            $message .= "Monthly Savings: ₹" . number_format($monthly_savings) . "\n";
            $message .= "Lead Score: " . $lead_score . "/100\n";
            
            $headers = "From: noreply@zerowhatsolar.in\r\n";
            $headers .= "Reply-To: " . $data['email'] . "\r\n";
            
            mail($to, $subject, $message, $headers);
        } catch (Exception $e) {
            error_log('Email sending failed: ' . $e->getMessage());
        }
    }
    
    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>