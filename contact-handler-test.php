<?php
/**
 * Royal Albatross Exports - Contact Form Handler (TEST VERSION)
 * This version saves submissions to a file instead of sending emails
 * Use this for local testing, then switch to contact-handler.php on production
 */

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'php-errors.log');

// Set content type to JSON
header('Content-Type: application/json');

// Allow CORS if needed
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Configuration
$config = [
    'recipient_email' => 'royalalbatrossexports@gmail.com',
    'test_mode' => true, // Set to false on production
    'save_to_file' => true, // Save submissions to file for testing
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
$humanCheck = isset($_POST['human_check']) ? $_POST['human_check'] : '';

// Collect visitor information
$ipAddress = $_SERVER['REMOTE_ADDR'];
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct Visit';
$requestTime = date('F j, Y, g:i:s a T');
$timezone = isset($_POST['timezone']) ? sanitizeInput($_POST['timezone']) : 'Not provided';
$browserLang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5) : 'Unknown';

// Parse user agent for browser and OS info
function getBrowserInfo($userAgent) {
    $browser = 'Unknown';
    $os = 'Unknown';
    
    // Detect browser
    if (preg_match('/MSIE/i', $userAgent) || preg_match('/Trident/i', $userAgent)) {
        $browser = 'Internet Explorer';
    } elseif (preg_match('/Edge/i', $userAgent)) {
        $browser = 'Microsoft Edge';
    } elseif (preg_match('/Chrome/i', $userAgent)) {
        $browser = 'Google Chrome';
    } elseif (preg_match('/Safari/i', $userAgent)) {
        $browser = 'Safari';
    } elseif (preg_match('/Firefox/i', $userAgent)) {
        $browser = 'Mozilla Firefox';
    } elseif (preg_match('/Opera/i', $userAgent)) {
        $browser = 'Opera';
    }
    
    // Detect OS
    if (preg_match('/Windows/i', $userAgent)) {
        $os = 'Windows';
    } elseif (preg_match('/Mac/i', $userAgent)) {
        $os = 'MacOS';
    } elseif (preg_match('/Linux/i', $userAgent)) {
        $os = 'Linux';
    } elseif (preg_match('/Android/i', $userAgent)) {
        $os = 'Android';
    } elseif (preg_match('/iOS|iPhone|iPad/i', $userAgent)) {
        $os = 'iOS';
    }
    
    return ['browser' => $browser, 'os' => $os];
}

$browserInfo = getBrowserInfo($userAgent);
$browser = $browserInfo['browser'];
$operatingSystem = $browserInfo['os'];

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

// Human verification check
if ($humanCheck !== 'yes') {
    $errors[] = 'Please confirm that you are human by checking the verification box.';
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

// Save submission to file (for testing)
if ($config['save_to_file']) {
    $submissionData = "
================================================================================
NEW INQUIRY RECEIVED
================================================================================
Date/Time: {$requestTime}

CUSTOMER INFORMATION:
--------------------
Name: {$name}
Company: {$company}
Email: {$email}
Phone: {$phone}
Country: {$country}
Product Interest: {$productName}
Estimated Quantity: {$quantity}
Message: {$message}

VISITOR INFORMATION:
-------------------
IP Address: {$ipAddress}
Browser: {$browser}
Operating System: {$operatingSystem}
Timezone: {$timezone}
Browser Language: {$browserLang}
Referrer: {$referrer}
User Agent: {$userAgent}
Human Verification: Passed

================================================================================

";
    
    file_put_contents('test-submissions.txt', $submissionData, FILE_APPEND);
}

// Log the inquiry with detailed information
$logEntry = date('Y-m-d H:i:s') . " | {$name} | {$email} | {$company} | {$productName} | IP: {$ipAddress} | Browser: {$browser} | OS: {$operatingSystem}\n";
file_put_contents('inquiries.log', $logEntry, FILE_APPEND);

// Send success response
sendResponse(true, '✅ TEST MODE: Your inquiry has been saved to test-submissions.txt! In production, this will send an email. Check the file to see all captured data.', [
    'inquiry_id' => uniqid('INQ-'),
    'timestamp' => date('Y-m-d H:i:s'),
    'test_mode' => true,
    'saved_to' => 'test-submissions.txt'
]);
?>
