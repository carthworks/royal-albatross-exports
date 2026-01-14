<?php
/**
 * Enhanced Visitor Tracking System
 * Tracks comprehensive visitor information including sessions, location, and behavior
 */

// File to store detailed visitor logs
$visitorLogFile = 'visitor-logs.json';
$sessionLogFile = 'session-logs.json';

// Start session for tracking
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get visitor information
function getVisitorInfo() {
    // Generate or retrieve session ID
    if (!isset($_SESSION['visitor_session_id'])) {
        $_SESSION['visitor_session_id'] = uniqid('sess_', true);
        $_SESSION['session_start'] = date('Y-m-d H:i:s');
    }
    
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $referer = $_SERVER['HTTP_REFERER'] ?? 'Direct';
    
    $info = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip_address' => getClientIP(),
        'session_id' => $_SESSION['visitor_session_id'],
        'user_agent' => $userAgent,
        'referer' => $referer,
        'request_uri' => $_SERVER['REQUEST_URI'] ?? '/',
        'page' => basename($_SERVER['PHP_SELF'] ?? 'unknown'),
        'country' => getCountryFromIP(getClientIP()),
        'city' => getCityFromIP(getClientIP()),
        'browser' => getBrowser($userAgent),
        'os' => getOS($userAgent),
        'device_type' => getDeviceType($userAgent),
        'traffic_source' => getTrafficSource($referer),
        'session_start' => $_SESSION['session_start'],
        'session_end' => date('Y-m-d H:i:s'),
        'time_spent_seconds' => calculateTimeSpent(),
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

// Get real client IP address
function getClientIP() {
    $ipAddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipAddress = $_SERVER['HTTP_FORWARDED'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipAddress = 'UNKNOWN';
    }
    return $ipAddress;
}

// Get country from IP (using free API)
function getCountryFromIP($ip) {
    if ($ip === 'UNKNOWN' || $ip === '127.0.0.1' || strpos($ip, '192.168.') === 0) {
        return 'Local/Unknown';
    }
    
    try {
        $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country");
        if ($response) {
            $data = json_decode($response, true);
            return $data['country'] ?? 'Unknown';
        }
    } catch (Exception $e) {
        // Silently fail
    }
    return 'Unknown';
}

// Get city from IP (using free API)
function getCityFromIP($ip) {
    if ($ip === 'UNKNOWN' || $ip === '127.0.0.1' || strpos($ip, '192.168.') === 0) {
        return 'Local/Unknown';
    }
    
    try {
        $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=city");
        if ($response) {
            $data = json_decode($response, true);
            return $data['city'] ?? 'Unknown';
        }
    } catch (Exception $e) {
        // Silently fail
    }
    return 'Unknown';
}

// Enhanced browser detection
function getBrowser($userAgent) {
    if (strpos($userAgent, 'Edg') !== false) return 'Edge';
    if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
    if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
    if (strpos($userAgent, 'Safari') !== false) return 'Safari';
    if (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) return 'Opera';
    if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) return 'Internet Explorer';
    return 'Unknown';
}

// Enhanced OS detection
function getOS($userAgent) {
    if (strpos($userAgent, 'Windows NT 10') !== false) return 'Windows 10/11';
    if (strpos($userAgent, 'Windows NT 6.3') !== false) return 'Windows 8.1';
    if (strpos($userAgent, 'Windows NT 6.2') !== false) return 'Windows 8';
    if (strpos($userAgent, 'Windows NT 6.1') !== false) return 'Windows 7';
    if (strpos($userAgent, 'Windows') !== false) return 'Windows';
    if (strpos($userAgent, 'Mac OS X') !== false) return 'macOS';
    if (strpos($userAgent, 'Linux') !== false) return 'Linux';
    if (strpos($userAgent, 'Android') !== false) return 'Android';
    if (strpos($userAgent, 'iOS') !== false || strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) return 'iOS';
    return 'Unknown';
}

// Detect device type
function getDeviceType($userAgent) {
    if (preg_match('/mobile|android|iphone|ipod|blackberry|iemobile|opera mini/i', $userAgent)) {
        return 'Mobile';
    } elseif (preg_match('/tablet|ipad|playbook|silk/i', $userAgent)) {
        return 'Tablet';
    }
    return 'Desktop';
}

// Determine traffic source
function getTrafficSource($referer) {
    if ($referer === 'Direct' || empty($referer)) {
        return 'Direct';
    }
    
    $referer = strtolower($referer);
    
    // Search engines
    if (strpos($referer, 'google') !== false) return 'Google Search';
    if (strpos($referer, 'bing') !== false) return 'Bing Search';
    if (strpos($referer, 'yahoo') !== false) return 'Yahoo Search';
    if (strpos($referer, 'duckduckgo') !== false) return 'DuckDuckGo';
    
    // Social media
    if (strpos($referer, 'facebook') !== false) return 'Facebook';
    if (strpos($referer, 'twitter') !== false || strpos($referer, 't.co') !== false) return 'Twitter';
    if (strpos($referer, 'linkedin') !== false) return 'LinkedIn';
    if (strpos($referer, 'instagram') !== false) return 'Instagram';
    if (strpos($referer, 'youtube') !== false) return 'YouTube';
    
    // Extract domain
    $host = parse_url($referer, PHP_URL_HOST);
    return $host ? 'Referral: ' . $host : 'Other';
}

// Calculate time spent on site
function calculateTimeSpent() {
    if (!isset($_SESSION['session_start'])) {
        return 0;
    }
    
    $start = strtotime($_SESSION['session_start']);
    $now = time();
    return $now - $start;
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
