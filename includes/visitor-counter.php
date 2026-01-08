<?php
/**
 * Visitor Counter System
 * Tracks unique visitors and total page views
 */

// File to store visitor data
$counterFile = 'visitor-counter.json';

// Initialize counter data
$counterData = [
    'total_visits' => 0,
    'unique_visitors' => 0,
    'last_reset' => date('Y-m-d H:i:s'),
    'visitors' => []
];

// Load existing data if file exists
if (file_exists($counterFile)) {
    $json = file_get_contents($counterFile);
    $existingData = json_decode($json, true);
    if ($existingData) {
        $counterData = $existingData;
    }
}

// Get visitor identifier (IP + User Agent for better uniqueness)
$visitorIP = $_SERVER['REMOTE_ADDR'];
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
$visitorHash = md5($visitorIP . $userAgent);

// Check if this is a unique visitor (not seen in last 24 hours)
$isNewVisitor = true;
$currentTime = time();
$oneDayAgo = $currentTime - (24 * 60 * 60);

// Clean up old visitor records (older than 24 hours)
$counterData['visitors'] = array_filter($counterData['visitors'], function($timestamp) use ($oneDayAgo) {
    return $timestamp > $oneDayAgo;
});

// Check if visitor exists in recent records
if (isset($counterData['visitors'][$visitorHash])) {
    $isNewVisitor = false;
}

// Update counters
$counterData['total_visits']++;
if ($isNewVisitor) {
    $counterData['unique_visitors']++;
    $counterData['visitors'][$visitorHash] = $currentTime;
}

// Save updated data
file_put_contents($counterFile, json_encode($counterData, JSON_PRETTY_PRINT));

// Return counter data
return $counterData;
?>
