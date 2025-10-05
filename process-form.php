<?php
// Include database connection
require_once 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input to prevent injection attacks
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($_POST["phone"]), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST["message"] ?? ''), FILTER_SANITIZE_STRING);
    $property_type = filter_var(trim($_POST["property_type"] ?? ''), FILTER_SANITIZE_STRING);
    $monthly_bill = filter_var(trim($_POST["monthly_bill"] ?? ''), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $address = filter_var(trim($_POST["address"] ?? ''), FILTER_SANITIZE_STRING);
    $whatsapp_updates = isset($_POST["whatsapp_updates"]) ? 1 : 0;

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?status=error&msg=invalid_email");
        exit;
    }
    
    // Check that required fields are not empty
    if (empty($name) || empty($email) || empty($phone)) {
        header("Location: contact.php?status=error&msg=missing_fields");
        exit;
    }

    // Validate phone number (10 digits)
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        header("Location: contact.php?status=error&msg=invalid_phone");
        exit;
    }

    // Calculate lead score
    $lead_score = 0;
    if ($property_type) $lead_score += 2;
    if ($monthly_bill) $lead_score += 3;
    if ($address) $lead_score += 1;
    if ($message) $lead_score += 1;
    
    // Get user IP and user agent
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    // Save to database
    try {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            INSERT INTO contact_submissions 
            (name, email, phone, property_type, monthly_bill, address, message, whatsapp_updates, lead_score, status, source, ip_address, user_agent, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'unread', 'website', ?, ?, NOW())
        ");
        
        $stmt->execute([
            $name, 
            $email, 
            $phone, 
            $property_type, 
            $monthly_bill, 
            $address, 
            $message, 
            $whatsapp_updates, 
            $lead_score, 
            $ip_address, 
            $user_agent
        ]);
        
        $submission_id = $db->lastInsertId();
        
    } catch (Exception $e) {
        // Log database error but continue with email
        error_log("Database Error in contact form: " . $e->getMessage());
    }

    // --- Email Sending Logic ---
    $recipient = "contact@zerowhatsolar.in"; // Your client's email address
    $subject = "🌟 New Solar Inquiry from $name - Zero What Solar";

    $email_content = "You have received a new solar inquiry from your website.\n\n";
    $email_content .= "=== CUSTOMER DETAILS ===\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    
    if ($property_type) {
        $email_content .= "Property Type: $property_type\n";
    }
    
    if ($monthly_bill) {
        $email_content .= "Monthly Electricity Bill: ₹$monthly_bill\n";
    }
    
    if ($address) {
        $email_content .= "Address: $address\n";
    }
    
    $email_content .= "WhatsApp Updates: $whatsapp_updates\n";
    
    if ($message) {
        $email_content .= "\n=== MESSAGE ===\n$message\n";
    }
    
    $email_content .= "\n=== LEAD SCORE ===\n";
    $lead_score = 0;
    if ($property_type) $lead_score += 2;
    if ($monthly_bill) $lead_score += 3;
    if ($address) $lead_score += 1;
    if ($message) $lead_score += 1;
    
    $email_content .= "Lead Quality Score: $lead_score/7\n";
    
    if ($lead_score >= 5) {
        $email_content .= "🔥 HIGH PRIORITY LEAD - Contact within 2 hours\n";
    } elseif ($lead_score >= 3) {
        $email_content .= "⚡ MEDIUM PRIORITY LEAD - Contact within 24 hours\n";
    }
    
    $email_content .= "\nSubmitted on: " . date('Y-m-d H:i:s') . "\n";
    $email_content .= "Source: Zero What Solar Website\n";

    $email_headers = "From: Zero What Solar <noreply@zerowhatsolar.in>\r\n";
    $email_headers .= "Reply-To: $name <$email>\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Log the inquiry (you can add database logging here)
    error_log("Solar Inquiry: $name - $email - $phone - Score: $lead_score");

    // The mail() function requires a configured mail server to work.
    // On a live web host, this usually works out of the box. On a local XAMPP setup, it will not.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Redirect to a "thank you" page on success
        header("Location: contact.php?status=success");
        exit;
    } else {
        // Handle mail sending failure
        header("Location: contact.php?status=error&msg=mail_failed");
        exit;
    }

} else {
    // Not a POST request, redirect back to the form
    header("Location: contact.php");
    exit;
}
?>