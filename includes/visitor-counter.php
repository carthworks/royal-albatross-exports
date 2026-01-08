<?php
/**
 * Visitor Counter System
 * Displays visitor statistics from the tracking system
 */

// File to store visitor data
$visitorLogFile = 'visitor-logs.json';

// Initialize counter data
$counterData = [
    'total_visits' => 0,
    'unique_visitors' => 0,
    'last_reset' => date('Y-m-d H:i:s'),
    'visitors' => []
];

// Load visitor logs if file exists
if (file_exists($visitorLogFile)) {
    $json = file_get_contents($visitorLogFile);
    $visitorLogs = json_decode($json, true);
    
    if ($visitorLogs && is_array($visitorLogs)) {
        // Calculate total visits
        $counterData['total_visits'] = count($visitorLogs);
        
        // Calculate unique visitors (unique IP addresses)
        $uniqueIPs = [];
        foreach ($visitorLogs as $log) {
            if (isset($log['ip_address'])) {
                $uniqueIPs[$log['ip_address']] = true;
            }
        }
        $counterData['unique_visitors'] = count($uniqueIPs);
        
        // Get the timestamp of the first log
        if (!empty($visitorLogs)) {
            $counterData['last_reset'] = $visitorLogs[0]['timestamp'] ?? date('Y-m-d H:i:s');
        }
    }
}

// Return counter data
return $counterData;
?>
