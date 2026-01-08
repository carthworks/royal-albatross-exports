<?php
/**
 * Enhanced Visitor Tracking System
 * Tracks detailed visitor information including IP addresses
 */

// File to store detailed visitor logs
$visitorLogFile = 'visitor-logs.json';

// Get visitor information
function getVisitorInfo() {
    $info = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'referer' => $_SERVER['HTTP_REFERER'] ?? 'Direct',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? '/',
        'country' => 'Unknown', // Can be enhanced with GeoIP
        'browser' => getBrowser($_SERVER['HTTP_USER_AGENT'] ?? ''),
        'os' => getOS($_SERVER['HTTP_USER_AGENT'] ?? ''),
    ];
    
    // Try to get more IP details if behind proxy
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $info['forwarded_ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $info['client_ip'] = $_SERVER['HTTP_CLIENT_IP'];
    }
    
    return $info;
}

// Simple browser detection
function getBrowser($userAgent) {
    if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
    if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
    if (strpos($userAgent, 'Safari') !== false) return 'Safari';
    if (strpos($userAgent, 'Edge') !== false) return 'Edge';
    if (strpos($userAgent, 'Opera') !== false) return 'Opera';
    if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) return 'Internet Explorer';
    return 'Unknown';
}

// Simple OS detection
function getOS($userAgent) {
    if (strpos($userAgent, 'Windows') !== false) return 'Windows';
    if (strpos($userAgent, 'Mac') !== false) return 'macOS';
    if (strpos($userAgent, 'Linux') !== false) return 'Linux';
    if (strpos($userAgent, 'Android') !== false) return 'Android';
    if (strpos($userAgent, 'iOS') !== false || strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) return 'iOS';
    return 'Unknown';
}

// Load existing logs
$visitorLogs = [];
if (file_exists($visitorLogFile)) {
    $json = file_get_contents($visitorLogFile);
    $existingLogs = json_decode($json, true);
    if ($existingLogs && is_array($existingLogs)) {
        $visitorLogs = $existingLogs;
    }
}

// Add new visitor log
$visitorLogs[] = getVisitorInfo();

// Keep only last 1000 entries to prevent file from getting too large
if (count($visitorLogs) > 1000) {
    $visitorLogs = array_slice($visitorLogs, -1000);
}

// Save updated logs
file_put_contents($visitorLogFile, json_encode($visitorLogs, JSON_PRETTY_PRINT));

?>
