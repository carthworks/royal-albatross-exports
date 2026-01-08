<?php
/**
 * PHP Information Page
 * Use this to check your hosting server configuration
 * 
 * IMPORTANT SECURITY NOTE:
 * Delete this file after checking your server configuration!
 * This file exposes sensitive server information.
 */

// Optional: Add password protection
$password = "royal2024"; // Change this password!
$entered_password = isset($_GET['pass']) ? $_GET['pass'] : '';

if ($entered_password !== $password) {
    die('Access Denied. Use: phpinfo.php?pass=YOUR_PASSWORD');
}

// Display PHP configuration
phpinfo();

// Additional useful information
echo '<hr><h2>Additional Server Information</h2>';
echo '<p><strong>Server Software:</strong> ' . $_SERVER['SERVER_SOFTWARE'] . '</p>';
echo '<p><strong>PHP Version:</strong> ' . phpversion() . '</p>';
echo '<p><strong>Document Root:</strong> ' . $_SERVER['DOCUMENT_ROOT'] . '</p>';
echo '<p><strong>Server Name:</strong> ' . $_SERVER['SERVER_NAME'] . '</p>';
echo '<p><strong>Server Admin:</strong> ' . (isset($_SERVER['SERVER_ADMIN']) ? $_SERVER['SERVER_ADMIN'] : 'N/A') . '</p>';

// Check important PHP extensions
echo '<hr><h2>Important Extensions Status</h2>';
$extensions = ['mysqli', 'pdo', 'pdo_mysql', 'curl', 'gd', 'mbstring', 'openssl', 'zip', 'xml'];
echo '<ul>';
foreach ($extensions as $ext) {
    $status = extension_loaded($ext) ? '✓ Enabled' : '✗ Disabled';
    $color = extension_loaded($ext) ? 'green' : 'red';
    echo "<li style='color: $color;'><strong>$ext:</strong> $status</li>";
}
echo '</ul>';

echo '<hr><p style="color: red; font-weight: bold;">⚠️ REMEMBER TO DELETE THIS FILE AFTER USE!</p>';
?>
