<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "=== PHP Debug Test ===<br><br>";

// Test 1: PHP Version
echo "1. PHP Version: " . phpversion() . "<br>";

// Test 2: Session
echo "2. Testing session...<br>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    echo "   ✓ Session started successfully<br>";
} else {
    echo "   ✓ Session already active<br>";
}

// Test 3: File permissions
echo "<br>3. Testing file write permissions...<br>";
$testFiles = [
    'security-logs.json',
    'blocked-ips.json',
    'rate-limits.json',
    'visitor-logs.json',
    'session-logs.json'
];

foreach ($testFiles as $file) {
    if (file_exists($file)) {
        if (is_writable($file)) {
            echo "   ✓ $file - exists and writable<br>";
        } else {
            echo "   ✗ $file - exists but NOT writable<br>";
        }
    } else {
        // Try to create it
        if (@file_put_contents($file, '[]')) {
            echo "   ✓ $file - created successfully<br>";
        } else {
            echo "   ✗ $file - CANNOT create (permission denied)<br>";
        }
    }
}

// Test 4: Include security.php
echo "<br>4. Testing security.php include...<br>";
try {
    if (file_exists('includes/security.php')) {
        require_once 'includes/security.php';
        echo "   ✓ security.php included successfully<br>";
        
        // Test if functions exist
        if (function_exists('getClientIP')) {
            echo "   ✓ getClientIP() function exists<br>";
            $ip = getClientIP();
            echo "   ✓ Your IP: $ip<br>";
        }
        
        if (function_exists('initSecurity')) {
            echo "   ✓ initSecurity() function exists<br>";
        }
    } else {
        echo "   ✗ includes/security.php NOT FOUND<br>";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "<br>";
}

// Test 5: Include visitor-tracker.php
echo "<br>5. Testing visitor-tracker.php include...<br>";
try {
    if (file_exists('includes/visitor-tracker.php')) {
        require_once 'includes/visitor-tracker.php';
        echo "   ✓ visitor-tracker.php included successfully<br>";
    } else {
        echo "   ✗ includes/visitor-tracker.php NOT FOUND<br>";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "<br>";
}

// Test 6: Try initSecurity
echo "<br>6. Testing initSecurity() execution...<br>";
try {
    if (function_exists('initSecurity')) {
        // We won't actually call it as it might block us
        echo "   ⚠ initSecurity() exists but not calling (might trigger rate limits)<br>";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "<br>";
}

echo "<br>=== Test Complete ===<br>";
echo "<br><strong>If you see this message, basic PHP is working!</strong><br>";
?>
