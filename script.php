<?php
/**
 * Royal Albatross Exports - Contact Form Handler
 * Processes contact form submissions and sends email notifications
 */

// Enable error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php-errors.log');

// Set content type to JSON
header('Content-Type: application/json');

// Allow CORS if needed (adjust origin as needed)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Configuration
$config = [
    'recipient_email' => 'royalalbatrossexports@gmail.com',
    'cc_email' => '', // Optional CC email
    'from_email' => 'noreply@royalalbatrossexport.com',
    'from_name' => 'Royal Albatross Exports Website',
    'subject_prefix' => '[Website Inquiry]',
    'enable_auto_reply' => true,
    'max_file_size' => 5242880, // 5MB
    'allowed_extensions' => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'],
];

// Response function
function sendResponse($success, $message, $data = []) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    exit;
}

// Validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method. Only POST requests are allowed.');
}

// Get POST data
$name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
$company = isset($_POST['company']) ? sanitizeInput($_POST['company']) : '';
$email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
$phone = isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : '';
$country = isset($_POST['country']) ? sanitizeInput($_POST['country']) : '';
$product = isset($_POST['product']) ? sanitizeInput($_POST['product']) : '';
$quantity = isset($_POST['quantity']) ? sanitizeInput($_POST['quantity']) : 'Not specified';
$message = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';

// Validation
$errors = [];

if (empty($name) || strlen($name) < 2) {
    $errors[] = 'Please provide a valid name (minimum 2 characters).';
}

if (empty($company) || strlen($company) < 2) {
    $errors[] = 'Please provide a valid company name (minimum 2 characters).';
}

if (empty($email) || !validateEmail($email)) {
    $errors[] = 'Please provide a valid email address.';
}

if (empty($phone) || strlen($phone) < 10) {
    $errors[] = 'Please provide a valid phone number (minimum 10 digits).';
}

if (empty($country) || strlen($country) < 2) {
    $errors[] = 'Please provide your country.';
}

if (empty($product)) {
    $errors[] = 'Please select a product of interest.';
}

if (empty($message) || strlen($message) < 10) {
    $errors[] = 'Please provide a detailed message (minimum 10 characters).';
}

// Check for spam (simple honeypot)
if (isset($_POST['website']) && !empty($_POST['website'])) {
    sendResponse(false, 'Spam detected.');
}

// If there are validation errors
if (!empty($errors)) {
    sendResponse(false, implode(' ', $errors));
}

// Product names mapping
$productNames = [
    'agricultural' => 'Agricultural Products',
    'agro' => 'Agro Products',
    'flowers' => 'Flower Products',
    'organic' => 'Organic Agro Products',
    'wholesale' => 'Flower Wholesale Supply',
    'custom' => 'Custom Export Orders'
];

$productName = isset($productNames[$product]) ? $productNames[$product] : $product;

// Prepare email content
$emailSubject = $config['subject_prefix'] . ' New Inquiry from ' . $name;

$emailBody = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #2d7a3e, #4caf50); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
        .field { margin-bottom: 20px; }
        .label { font-weight: bold; color: #2d7a3e; display: block; margin-bottom: 5px; }
        .value { background: white; padding: 10px; border-radius: 5px; border-left: 3px solid #2d7a3e; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e9ecef; color: #6c757d; font-size: 14px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>New Website Inquiry</h1>
            <p>Royal Albatross Exports</p>
        </div>
        <div class='content'>
            <div class='field'>
                <span class='label'>Name:</span>
                <div class='value'>{$name}</div>
            </div>
            <div class='field'>
                <span class='label'>Company:</span>
                <div class='value'>{$company}</div>
            </div>
            <div class='field'>
                <span class='label'>Email:</span>
                <div class='value'><a href='mailto:{$email}'>{$email}</a></div>
            </div>
            <div class='field'>
                <span class='label'>Phone:</span>
                <div class='value'><a href='tel:{$phone}'>{$phone}</a></div>
            </div>
            <div class='field'>
                <span class='label'>Country:</span>
                <div class='value'>{$country}</div>
            </div>
            <div class='field'>
                <span class='label'>Product Interest:</span>
                <div class='value'>{$productName}</div>
            </div>
            <div class='field'>
                <span class='label'>Estimated Quantity:</span>
                <div class='value'>{$quantity}</div>
            </div>
            <div class='field'>
                <span class='label'>Message:</span>
                <div class='value'>" . nl2br($message) . "</div>
            </div>
            <div class='footer'>
                <p>Received: " . date('F j, Y, g:i a') . "</p>
                <p>IP Address: " . $_SERVER['REMOTE_ADDR'] . "</p>
            </div>
        </div>
    </div>
</body>
</html>
";

// Email headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: {$config['from_name']} <{$config['from_email']}>\r\n";
$headers .= "Reply-To: {$name} <{$email}>\r\n";

if (!empty($config['cc_email'])) {
    $headers .= "Cc: {$config['cc_email']}\r\n";
}

// Send email
$mailSent = mail($config['recipient_email'], $emailSubject, $emailBody, $headers);

if (!$mailSent) {
    sendResponse(false, 'Failed to send email. Please try again later or contact us directly.');
}

// Send auto-reply to customer
if ($config['enable_auto_reply']) {
    $autoReplySubject = 'Thank you for contacting Royal Albatross Exports';
    
    $autoReplyBody = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #2d7a3e, #4caf50); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
            .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #e9ecef; color: #6c757d; font-size: 14px; }
            .contact-info { background: white; padding: 20px; border-radius: 5px; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Thank You!</h1>
                <p>Royal Albatross Exports</p>
            </div>
            <div class='content'>
                <p>Dear {$name},</p>
                <p>Thank you for your inquiry regarding <strong>{$productName}</strong>. We have received your message and our team will review it shortly.</p>
                <p>We typically respond to all inquiries within 24 hours during business days. One of our export specialists will contact you soon to discuss your requirements in detail.</p>
                
                <div class='contact-info'>
                    <h3 style='color: #2d7a3e; margin-top: 0;'>Contact Information</h3>
                    <p><strong>Phone:</strong> +91 94422 29082</p>
                    <p><strong>Email:</strong> royalalbatrossexports@gmail.com</p>
                    <p><strong>WhatsApp:</strong> +91 94422 29082</p>
                    <p><strong>Address:</strong> No. A-201, VKC Layout, Perur Main Road, Selvapuram, Coimbatore-641024, Tamil Nadu, India</p>
                </div>
                
                <p style='margin-top: 20px;'>For urgent inquiries, please feel free to contact us directly via phone or WhatsApp.</p>
                
                <div class='footer'>
                    <p><strong>Trusted Quality. Fresh Exports. Global Reach.</strong></p>
                    <p>© " . date('Y') . " Royal Albatross Exports. All rights reserved.</p>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $autoReplyHeaders = "MIME-Version: 1.0\r\n";
    $autoReplyHeaders .= "Content-type: text/html; charset=UTF-8\r\n";
    $autoReplyHeaders .= "From: {$config['from_name']} <{$config['from_email']}>\r\n";
    
    mail($email, $autoReplySubject, $autoReplyBody, $autoReplyHeaders);
}

// Log the inquiry (optional)
$logEntry = date('Y-m-d H:i:s') . " | {$name} | {$email} | {$company} | {$productName}\n";
file_put_contents('inquiries.log', $logEntry, FILE_APPEND);

// Send success response
sendResponse(true, 'Thank you for your inquiry! We will get back to you within 24 hours.', [
    'inquiry_id' => uniqid('INQ-'),
    'timestamp' => date('Y-m-d H:i:s')
]);
?>
