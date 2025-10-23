<?php
/**
 * Vercel Serverless Function for Contact Form Processing
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
    $required_fields = ['name', 'email', 'phone', 'message'];
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            throw new Exception("Field '$field' is required");
        }
    }
    
    // Sanitize input
    $data = [
        'name' => filter_var($input['name'], FILTER_SANITIZE_STRING),
        'email' => filter_var($input['email'], FILTER_VALIDATE_EMAIL),
        'phone' => filter_var($input['phone'], FILTER_SANITIZE_STRING),
        'property_type' => isset($input['property_type']) ? filter_var($input['property_type'], FILTER_SANITIZE_STRING) : null,
        'monthly_bill' => isset($input['monthly_bill']) ? filter_var($input['monthly_bill'], FILTER_VALIDATE_FLOAT) : null,
        'address' => isset($input['address']) ? filter_var($input['address'], FILTER_SANITIZE_STRING) : null,
        'message' => filter_var($input['message'], FILTER_SANITIZE_STRING),
        'whatsapp_updates' => isset($input['whatsapp_updates']) ? (bool)$input['whatsapp_updates'] : false,
        'source' => 'website',
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ];
    
    if (!$data['email']) {
        throw new Exception('Invalid email address');
    }
    
    // Calculate lead score
    $lead_score = 0;
    if ($data['monthly_bill'] && $data['monthly_bill'] > 2000) $lead_score += 30;
    if ($data['property_type'] && in_array($data['property_type'], ['independent_house', 'villa'])) $lead_score += 20;
    if ($data['phone']) $lead_score += 25;
    if ($data['whatsapp_updates']) $lead_score += 15;
    if (strlen($data['message']) > 50) $lead_score += 10;
    
    $data['lead_score'] = $lead_score;
    
    // Insert into database
    $db = getDBInstance();
    $id = $db->insert('contact_submissions', $data);
    
    // Send notification email (optional)
    $email_sent = false;
    if (defined('SMTP_HOST') && SMTP_HOST) {
        try {
            // Configure PHPMailer or use mail() function
            $to = 'contact@zerowhatsolar.in';
            $subject = 'New Contact Form Submission - Zero What Solar';
            $message = "New contact form submission received:\n\n";
            $message .= "Name: " . $data['name'] . "\n";
            $message .= "Email: " . $data['email'] . "\n";
            $message .= "Phone: " . $data['phone'] . "\n";
            $message .= "Message: " . $data['message'] . "\n";
            $message .= "Lead Score: " . $data['lead_score'] . "\n";
            
            $headers = "From: noreply@zerowhatsolar.in\r\n";
            $headers .= "Reply-To: " . $data['email'] . "\r\n";
            
            $email_sent = mail($to, $subject, $message, $headers);
        } catch (Exception $e) {
            error_log('Email sending failed: ' . $e->getMessage());
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for your inquiry! We will contact you soon.',
        'submission_id' => $id,
        'lead_score' => $lead_score,
        'email_sent' => $email_sent
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>