<?php
/**
 * Royal Albatross Exports - Security Module
 * Comprehensive website security and protection system
 * 
 * Features:
 * - SQL Injection Protection
 * - XSS (Cross-Site Scripting) Protection
 * - CSRF (Cross-Site Request Forgery) Protection
 * - Rate Limiting / DDoS Protection
 * - IP Blocking / Whitelist
 * - Security Headers
 * - Input Validation & Sanitization
 * - Suspicious Activity Detection
 * - Security Logging
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuration
define('SECURITY_LOG_FILE', 'security-logs.json');
define('BLOCKED_IPS_FILE', 'blocked-ips.json');
define('RATE_LIMIT_FILE', 'rate-limits.json');
define('MAX_REQUESTS_PER_MINUTE', 60);
define('MAX_REQUESTS_PER_HOUR', 500);
define('AUTO_BLOCK_THRESHOLD', 10); // Auto-block after 10 violations
define('BLOCK_DURATION_HOURS', 24);

/**
 * Initialize Security Module
 * Call this at the beginning of each page
 */
function initSecurity() {
    // Set secure headers
    setSecurityHeaders();
    
    // Check if IP is blocked
    $ip = getClientIP();
    if (isIPBlocked($ip)) {
        blockAccess('Your IP has been blocked due to suspicious activity.');
    }
    
    // Rate limiting
    if (!checkRateLimit($ip)) {
        logSecurityEvent('RATE_LIMIT_EXCEEDED', $ip, 'Too many requests');
        blockAccess('Too many requests. Please try again later.');
    }
    
    // Detect suspicious patterns
    detectSuspiciousActivity();
    
    // Regenerate session ID periodically
    regenerateSessionPeriodically();
}

/**
 * Set Security Headers
 */
function setSecurityHeaders() {
    // Suppress errors if headers already sent
    if (headers_sent()) {
        return;
    }
    
    // Prevent clickjacking
    @header('X-Frame-Options: SAMEORIGIN');
    
    // XSS Protection
    @header('X-XSS-Protection: 1; mode=block');
    
    // Prevent MIME type sniffing
    @header('X-Content-Type-Options: nosniff');
    
    // Referrer Policy
    @header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // Content Security Policy (relaxed for external resources)
    @header("Content-Security-Policy: default-src 'self' https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://www.googletagmanager.com https://www.google-analytics.com https://www.youtube.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://unpkg.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data: https:; frame-src 'self' https://www.youtube.com;");
    
    // Strict Transport Security (HTTPS only)
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        @header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
    
    // Permissions Policy
    @header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
}

/**
 * Get Real Client IP Address
 */
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
    
    // Handle multiple IPs (take first one)
    if (strpos($ipAddress, ',') !== false) {
        $ipAddress = trim(explode(',', $ipAddress)[0]);
    }
    
    return $ipAddress;
}

/**
 * Check if IP is Blocked
 */
function isIPBlocked($ip) {
    if (!file_exists(BLOCKED_IPS_FILE)) {
        return false;
    }
    
    $blockedIPs = json_decode(file_get_contents(BLOCKED_IPS_FILE), true) ?? [];
    
    if (isset($blockedIPs[$ip])) {
        $blockInfo = $blockedIPs[$ip];
        
        // Check if block has expired
        if (isset($blockInfo['expires']) && time() > $blockInfo['expires']) {
            unset($blockedIPs[$ip]);
            file_put_contents(BLOCKED_IPS_FILE, json_encode($blockedIPs, JSON_PRETTY_PRINT));
            return false;
        }
        
        return true;
    }
    
    return false;
}

/**
 * Block an IP Address
 */
function blockIP($ip, $reason = 'Security violation', $duration = BLOCK_DURATION_HOURS) {
    $blockedIPs = [];
    
    if (file_exists(BLOCKED_IPS_FILE)) {
        $blockedIPs = json_decode(file_get_contents(BLOCKED_IPS_FILE), true) ?? [];
    }
    
    $blockedIPs[$ip] = [
        'reason' => $reason,
        'blocked_at' => date('Y-m-d H:i:s'),
        'expires' => time() + ($duration * 3600),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
    ];
    
    file_put_contents(BLOCKED_IPS_FILE, json_encode($blockedIPs, JSON_PRETTY_PRINT));
    logSecurityEvent('IP_BLOCKED', $ip, $reason);
}

/**
 * Rate Limiting
 */
function checkRateLimit($ip) {
    $rateLimits = [];
    
    if (file_exists(RATE_LIMIT_FILE)) {
        $rateLimits = json_decode(file_get_contents(RATE_LIMIT_FILE), true) ?? [];
    }
    
    $now = time();
    $oneMinuteAgo = $now - 60;
    $oneHourAgo = $now - 3600;
    
    // Initialize or get IP data
    if (!isset($rateLimits[$ip])) {
        $rateLimits[$ip] = ['requests' => []];
    }
    
    // Clean old requests
    $rateLimits[$ip]['requests'] = array_filter($rateLimits[$ip]['requests'], function($timestamp) use ($oneHourAgo) {
        return $timestamp > $oneHourAgo;
    });
    
    // Count requests
    $requestsLastMinute = count(array_filter($rateLimits[$ip]['requests'], function($timestamp) use ($oneMinuteAgo) {
        return $timestamp > $oneMinuteAgo;
    }));
    
    $requestsLastHour = count($rateLimits[$ip]['requests']);
    
    // Check limits
    if ($requestsLastMinute > MAX_REQUESTS_PER_MINUTE) {
        blockIP($ip, 'Rate limit exceeded (per minute)', 1);
        return false;
    }
    
    if ($requestsLastHour > MAX_REQUESTS_PER_HOUR) {
        blockIP($ip, 'Rate limit exceeded (per hour)', 6);
        return false;
    }
    
    // Add current request
    $rateLimits[$ip]['requests'][] = $now;
    
    // Save
    file_put_contents(RATE_LIMIT_FILE, json_encode($rateLimits, JSON_PRETTY_PRINT));
    
    return true;
}

/**
 * Detect Suspicious Activity
 */
function detectSuspiciousActivity() {
    $ip = getClientIP();
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    $queryString = $_SERVER['QUERY_STRING'] ?? '';
    
    // SQL Injection patterns
    $sqlPatterns = [
        '/(\bUNION\b.*\bSELECT\b)/i',
        '/(\bSELECT\b.*\bFROM\b)/i',
        '/(\bINSERT\b.*\bINTO\b)/i',
        '/(\bDELETE\b.*\bFROM\b)/i',
        '/(\bDROP\b.*\bTABLE\b)/i',
        '/(\bUPDATE\b.*\bSET\b)/i',
        '/(\'|\"|;|--|\#|\/\*|\*\/)/i',
        '/(\bOR\b.*=.*)/i',
        '/(\bAND\b.*=.*)/i'
    ];
    
    // XSS patterns
    $xssPatterns = [
        '/<script[^>]*>.*?<\/script>/i',
        '/<iframe[^>]*>.*?<\/iframe>/i',
        '/javascript:/i',
        '/on\w+\s*=/i', // onclick, onload, etc.
        '/<img[^>]*onerror/i',
        '/eval\(/i',
        '/alert\(/i'
    ];
    
    // Path traversal patterns
    $pathTraversalPatterns = [
        '/\.\.\//i',
        '/\.\.\\/i',
        '/%2e%2e%2f/i',
        '/%2e%2e\\/i'
    ];
    
    // Common attack patterns
    $attackPatterns = [
        '/\/wp-admin/i',
        '/\/wp-login/i',
        '/\/phpmyadmin/i',
        '/\/admin/i',
        '/\.env/i',
        '/\.git/i',
        '/\/config\./i',
        '/\/backup/i'
    ];
    
    $violations = [];
    
    // Check for SQL injection
    foreach ($sqlPatterns as $pattern) {
        if (preg_match($pattern, $queryString) || preg_match($pattern, $requestUri)) {
            $violations[] = 'SQL_INJECTION_ATTEMPT';
            break;
        }
    }
    
    // Check for XSS
    foreach ($xssPatterns as $pattern) {
        if (preg_match($pattern, $queryString) || preg_match($pattern, $requestUri)) {
            $violations[] = 'XSS_ATTEMPT';
            break;
        }
    }
    
    // Check for path traversal
    foreach ($pathTraversalPatterns as $pattern) {
        if (preg_match($pattern, $requestUri)) {
            $violations[] = 'PATH_TRAVERSAL_ATTEMPT';
            break;
        }
    }
    
    // Check for common attacks
    foreach ($attackPatterns as $pattern) {
        if (preg_match($pattern, $requestUri)) {
            $violations[] = 'SUSPICIOUS_PATH_ACCESS';
            break;
        }
    }
    
    // Check for suspicious user agents
    $suspiciousAgents = ['sqlmap', 'nikto', 'nmap', 'masscan', 'nessus', 'burp', 'acunetix'];
    foreach ($suspiciousAgents as $agent) {
        if (stripos($userAgent, $agent) !== false) {
            $violations[] = 'SUSPICIOUS_USER_AGENT';
            break;
        }
    }
    
    // Log and block if violations found
    if (!empty($violations)) {
        foreach ($violations as $violation) {
            logSecurityEvent($violation, $ip, "URI: $requestUri | Query: $queryString");
        }
        
        // Auto-block after threshold
        $violationCount = countRecentViolations($ip);
        if ($violationCount >= AUTO_BLOCK_THRESHOLD) {
            blockIP($ip, 'Multiple security violations', BLOCK_DURATION_HOURS);
            blockAccess('Access denied due to security violations.');
        }
    }
}

/**
 * Count Recent Violations for IP
 */
function countRecentViolations($ip) {
    if (!file_exists(SECURITY_LOG_FILE)) {
        return 0;
    }
    
    $logs = json_decode(file_get_contents(SECURITY_LOG_FILE), true) ?? [];
    $oneHourAgo = time() - 3600;
    
    $count = 0;
    foreach ($logs as $log) {
        if ($log['ip'] === $ip && strtotime($log['timestamp']) > $oneHourAgo) {
            $count++;
        }
    }
    
    return $count;
}

/**
 * Log Security Event
 */
function logSecurityEvent($eventType, $ip, $details = '') {
    $logs = [];
    
    if (file_exists(SECURITY_LOG_FILE)) {
        $logs = json_decode(file_get_contents(SECURITY_LOG_FILE), true) ?? [];
    }
    
    $logs[] = [
        'timestamp' => date('Y-m-d H:i:s'),
        'event_type' => $eventType,
        'ip' => $ip,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? '',
        'details' => $details
    ];
    
    // Keep only last 1000 entries
    if (count($logs) > 1000) {
        $logs = array_slice($logs, -1000);
    }
    
    file_put_contents(SECURITY_LOG_FILE, json_encode($logs, JSON_PRETTY_PRINT));
}

/**
 * Block Access
 */
function blockAccess($message = 'Access Denied') {
    http_response_code(403);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Access Denied</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
            }
            .container {
                background: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                text-align: center;
                max-width: 500px;
            }
            .icon {
                font-size: 80px;
                color: #dc3545;
                margin-bottom: 20px;
            }
            h1 {
                color: #333;
                margin: 0 0 20px 0;
            }
            p {
                color: #666;
                line-height: 1.6;
            }
            .error-code {
                font-size: 100px;
                font-weight: bold;
                color: #e9ecef;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="error-code">403</div>
            <div class="icon">🛡️</div>
            <h1>Access Denied</h1>
            <p><?php echo htmlspecialchars($message); ?></p>
            <p style="font-size: 14px; color: #999; margin-top: 30px;">
                If you believe this is an error, please contact the website administrator.
            </p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

/**
 * Generate CSRF Token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF Token
 */
function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Sanitize Input (Enhanced)
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    
    return $data;
}

/**
 * Validate Email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate URL
 */
function validateURL($url) {
    return filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Regenerate Session Periodically
 */
function regenerateSessionPeriodically() {
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    }
    
    // Regenerate every 30 minutes
    if (time() - $_SESSION['last_regeneration'] > 1800) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

/**
 * Check if Request is HTTPS
 */
function isHTTPS() {
    return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
}

/**
 * Force HTTPS (Redirect if not HTTPS)
 */
function forceHTTPS() {
    if (!isHTTPS()) {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('Location: ' . $redirect, true, 301);
        exit;
    }
}

/**
 * Clean Old Log Files
 */
function cleanOldLogs($days = 30) {
    $files = [SECURITY_LOG_FILE, RATE_LIMIT_FILE];
    
    foreach ($files as $file) {
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true) ?? [];
            $cutoffDate = time() - ($days * 24 * 3600);
            
            $cleaned = array_filter($data, function($entry) use ($cutoffDate) {
                if (isset($entry['timestamp'])) {
                    return strtotime($entry['timestamp']) > $cutoffDate;
                }
                return true;
            });
            
            file_put_contents($file, json_encode(array_values($cleaned), JSON_PRETTY_PRINT));
        }
    }
}

// Auto-initialize security on include
// Comment this out if you want manual initialization
// initSecurity();

?>
