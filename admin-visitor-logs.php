<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Visitor Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .admin-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .admin-header h1 {
            margin: 0;
            color: #667eea;
            font-weight: 700;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin: 10px 0;
        }

        .stat-card p {
            color: #666;
            margin: 0;
            font-size: 0.9rem;
        }

        .logs-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .filter-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .table-container {
            overflow-x: auto;
            max-height: 600px;
            overflow-y: auto;
            border: 1px solid #e9ecef;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 2200px;
        }

        thead {
            position: sticky;
            top: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            z-index: 10;
        }

        thead th {
            padding: 15px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #e9ecef;
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        tbody td {
            padding: 12px 10px;
            color: #333;
            font-size: 0.9rem;
        }

        .ip-address {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #667eea;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .export-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .export-btn:hover {
            transform: scale(1.05);
        }

        .search-box {
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            width: 100%;
            max-width: 400px;
            transition: border-color 0.3s;
        }

        .search-box:focus {
            outline: none;
            border-color: #667eea;
        }
    </style>
</head>
<body>
    <?php
    /**
     * Admin Visitor Logs Dashboard
     * Enhanced visitor analytics with comprehensive tracking
     */
    
    // Simple password protection
    session_start();
    
    // Change this password to your desired admin password
    $ADMIN_PASSWORD = 'royal2026admin'; // CHANGE THIS!
    
    // Check if logout is requested
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: admin-visitor-logs.php');
        exit;
    }
    
    // Check if login form is submitted
    if (isset($_POST['password'])) {
        if ($_POST['password'] === $ADMIN_PASSWORD) {
            $_SESSION['admin_logged_in'] = true;
        } else {
            $loginError = 'Incorrect password!';
        }
    }
    
    // Show login form if not authenticated
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        ?>
        <div class="admin-container">
            <div class="admin-header text-center">
                <i class="fas fa-shield-alt" style="font-size: 3rem; color: #667eea;"></i>
                <h1 class="mt-3">Admin Access Required</h1>
                <p class="text-muted">Please enter the admin password to view visitor logs</p>
                
                <?php if (isset($loginError)): ?>
                    <div class="alert alert-danger mt-3"><?php echo $loginError; ?></div>
                <?php endif; ?>
                
                <form method="POST" class="mt-4" style="max-width: 400px; margin: 0 auto;">
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" 
                               placeholder="Enter admin password" required autofocus>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        exit;
    }
    
    // Load visitor logs
    $visitorLogFile = 'visitor-logs.json';
    $visitorLogs = [];
    
    if (file_exists($visitorLogFile)) {
        $json = file_get_contents($visitorLogFile);
        $visitorLogs = json_decode($json, true) ?? [];
    }
    
    // Reverse to show newest first
    $visitorLogs = array_reverse($visitorLogs);
    
    // Calculate statistics
    $totalVisits = count($visitorLogs);
    $uniqueIPs = count(array_unique(array_column($visitorLogs, 'ip_address')));
    $uniqueSessions = count(array_unique(array_column($visitorLogs, 'session_id')));
    
    // Browser statistics
    $browsers = array_count_values(array_column($visitorLogs, 'browser'));
    $topBrowser = $browsers ? array_keys($browsers, max($browsers))[0] : 'N/A';
    
    // Operating system statistics
    $operatingSystems = array_count_values(array_column($visitorLogs, 'os'));
    $topOS = $operatingSystems ? array_keys($operatingSystems, max($operatingSystems))[0] : 'N/A';
    
    // Device type statistics
    $deviceTypes = array_count_values(array_column($visitorLogs, 'device_type'));
    $topDevice = $deviceTypes ? array_keys($deviceTypes, max($deviceTypes))[0] : 'N/A';
    
    // Traffic source statistics
    $trafficSources = array_count_values(array_column($visitorLogs, 'traffic_source'));
    $topTrafficSource = $trafficSources ? array_keys($trafficSources, max($trafficSources))[0] : 'N/A';
    
    // Calculate average session duration
    $timeSpentValues = array_column($visitorLogs, 'time_spent_seconds');
    $avgTimeSpent = $timeSpentValues ? array_sum($timeSpentValues) / count($timeSpentValues) : 0;
    $avgTimeSpentFormatted = gmdate("i:s", (int)$avgTimeSpent);
    
    // Get today's visits
    $today = date('Y-m-d');
    $todayVisits = array_filter($visitorLogs, function($log) use ($today) {
        return strpos($log['timestamp'], $today) === 0;
    });
    $todayCount = count($todayVisits);
    
    // Get top countries
    $countries = array_count_values(array_filter(array_column($visitorLogs, 'country')));
    $topCountry = $countries ? array_keys($countries, max($countries))[0] : 'N/A';
    
    // Count form submissions
    $formSubmissions = array_filter($visitorLogs, function($log) {
        return isset($log['event_type']) && $log['event_type'] === 'FORM_SUBMISSION';
    });
    $formSubmissionCount = count($formSubmissions);
    ?>

    <div class="admin-container">
        <!-- Header -->
        <div class="admin-header d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-chart-line"></i> Visitor Analytics Dashboard</h1>
                <p class="text-muted mb-0">Comprehensive visitor tracking with session analytics</p>
            </div>
            <div>
                <button onclick="exportToCSV()" class="export-btn me-2">
                    <i class="fas fa-download"></i> Export CSV
                </button>
                <a href="?logout=1" class="btn btn-outline-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <!-- Total Visits -->
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3><?php echo number_format($totalVisits); ?></h3>
                <p>Total Visits</p>
            </div>

            <!-- Unique Visitors -->
            <div class="stat-card">
                <i class="fas fa-user-check"></i>
                <h3><?php echo number_format($uniqueIPs); ?></h3>
                <p>Unique Visitors</p>
            </div>

            <!-- Unique Sessions -->
            <div class="stat-card">
                <i class="fas fa-fingerprint"></i>
                <h3><?php echo number_format($uniqueSessions); ?></h3>
                <p>Unique Sessions</p>
            </div>

            <!-- Today's Visits -->
            <div class="stat-card">
                <i class="fas fa-calendar-day"></i>
                <h3><?php echo number_format($todayCount); ?></h3>
                <p>Today's Visits</p>
            </div>

            <!-- Top Browser -->
            <div class="stat-card">
                <i class="fas fa-globe"></i>
                <h3><?php echo $topBrowser; ?></h3>
                <p>Top Browser</p>
            </div>

            <!-- Top Device Type -->
            <div class="stat-card">
                <i class="fas fa-mobile-alt"></i>
                <h3><?php echo $topDevice; ?></h3>
                <p>Top Device Type</p>
            </div>

            <!-- Top Traffic Source -->
            <div class="stat-card">
                <i class="fas fa-share-alt"></i>
                <h3 style="font-size: 1.3rem;"><?php echo $topTrafficSource; ?></h3>
                <p>Top Traffic Source</p>
            </div>

            <!-- Average Session Time -->
            <div class="stat-card">
                <i class="fas fa-clock"></i>
                <h3><?php echo $avgTimeSpentFormatted; ?></h3>
                <p>Avg. Session Time</p>
            </div>

            <!-- Top Country -->
            <div class="stat-card">
                <i class="fas fa-map-marker-alt"></i>
                <h3><?php echo $topCountry; ?></h3>
                <p>Top Country</p>
            </div>

            <!-- Form Submissions -->
            <div class="stat-card" style="border: 2px solid #28a745;">
                <i class="fas fa-envelope-open-text" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);"></i>
                <h3><?php echo number_format($formSubmissionCount); ?></h3>
                <p>Form Submissions</p>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="logs-container">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-3 mb-md-0">
                            <i class="fas fa-list"></i> Visitor Logs
                        </h4>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchBox" class="search-box" 
                               placeholder="Search by IP, browser, OS, country...">
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-container">
                <table id="visitorTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Event</th>
                            <th>Timestamp</th>
                            <th>IP Address</th>
                            <th>Session ID</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Browser</th>
                            <th>OS</th>
                            <th>Device Type</th>
                            <th>Page</th>
                            <th>Referer</th>
                            <th>Traffic Source</th>
                            <th>Session Start</th>
                            <th>Session End</th>
                            <th>Time Spent</th>
                            <th>Form Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visitorLogs as $index => $log): 
                            $isFormSubmission = isset($log['event_type']) && $log['event_type'] === 'FORM_SUBMISSION';
                            $rowStyle = $isFormSubmission ? 'background-color: #d4edda;' : '';
                        ?>
                        <tr style="<?php echo $rowStyle; ?>">
                            <!-- Row Number -->
                            <td><?php echo $index + 1; ?></td>
                            
                            <!-- Event Type -->
                            <td>
                                <?php if ($isFormSubmission): ?>
                                    <span class="badge bg-success" style="font-size: 0.75rem;">
                                        <i class="fas fa-envelope"></i> FORM
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary" style="font-size: 0.75rem;">
                                        <i class="fas fa-eye"></i> VISIT
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <!-- Timestamp -->
                            <td><?php echo htmlspecialchars($log['timestamp']); ?></td>
                            
                            <!-- IP Address -->
                            <td class="ip-address">
                                <?php echo htmlspecialchars($log['ip_address']); ?>
                            </td>
                            
                            <!-- Session ID (truncated with tooltip) -->
                            <td style="font-family: 'Courier New', monospace; font-size: 0.85rem;" 
                                title="<?php echo htmlspecialchars($log['session_id'] ?? 'N/A'); ?>">
                                <?php echo htmlspecialchars(substr($log['session_id'] ?? 'N/A', 0, 12) . '...'); ?>
                            </td>
                            
                            <!-- Country -->
                            <td>
                                <span class="badge bg-info">
                                    <?php echo htmlspecialchars($log['country'] ?? 'Unknown'); ?>
                                </span>
                            </td>
                            
                            <!-- City -->
                            <td><?php echo htmlspecialchars($log['city'] ?? 'Unknown'); ?></td>
                            
                            <!-- Browser -->
                            <td>
                                <span class="badge bg-primary">
                                    <?php echo htmlspecialchars($log['browser']); ?>
                                </span>
                            </td>
                            
                            <!-- Operating System -->
                            <td>
                                <span class="badge bg-success">
                                    <?php echo htmlspecialchars($log['os']); ?>
                                </span>
                            </td>
                            
                            <!-- Device Type -->
                            <td>
                                <span class="badge bg-secondary">
                                    <?php echo htmlspecialchars($log['device_type'] ?? 'Unknown'); ?>
                                </span>
                            </td>
                            
                            <!-- Page -->
                            <td><?php echo htmlspecialchars($log['page'] ?? $log['request_uri']); ?></td>
                            
                            <!-- Referer (truncated with tooltip) -->
                            <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" 
                                title="<?php echo htmlspecialchars($log['referer']); ?>">
                                <?php echo htmlspecialchars($log['referer']); ?>
                            </td>
                            
                            <!-- Traffic Source -->
                            <td>
                                <span class="badge bg-warning text-dark">
                                    <?php echo htmlspecialchars($log['traffic_source'] ?? 'Unknown'); ?>
                                </span>
                            </td>
                            
                            <!-- Session Start -->
                            <td style="font-size: 0.85rem;">
                                <?php echo htmlspecialchars($log['session_start'] ?? 'N/A'); ?>
                            </td>
                            
                            <!-- Session End -->
                            <td style="font-size: 0.85rem;">
                                <?php echo htmlspecialchars($log['session_end'] ?? 'N/A'); ?>
                            </td>
                            
                            <!-- Time Spent -->
                            <td>
                                <?php 
                                $seconds = $log['time_spent_seconds'] ?? 0;
                                if ($seconds < 60) {
                                    echo $seconds . 's';
                                } else {
                                    echo gmdate("i:s", $seconds);
                                }
                                ?>
                            </td>
                            
                            <!-- Form Details -->
                            <td>
                                <?php if ($isFormSubmission && isset($log['form_data'])): 
                                    $formData = $log['form_data'];
                                ?>
                                    <div style="min-width: 200px; font-size: 0.85rem;">
                                        <strong>📧 <?php echo htmlspecialchars($formData['email'] ?? 'N/A'); ?></strong><br>
                                        <small>
                                            👤 <?php echo htmlspecialchars($formData['name'] ?? 'N/A'); ?><br>
                                            🏢 <?php echo htmlspecialchars($formData['company'] ?? 'N/A'); ?><br>
                                            📦 <?php echo htmlspecialchars($formData['product'] ?? 'N/A'); ?><br>
                                            📞 <?php echo htmlspecialchars($formData['phone'] ?? 'N/A'); ?>
                                        </small>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <!-- Empty State -->
                        <?php if (empty($visitorLogs)): ?>
                        <tr>
                            <td colspan="17" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>No visitor logs yet</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        /**
         * Search functionality
         * Filters table rows based on search input
         */
        document.getElementById('searchBox').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#visitorTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        /**
         * Export to CSV
         * Downloads visible table data as CSV file
         */
        function exportToCSV() {
            const table = document.getElementById('visitorTable');
            let csv = [];
            
            // Extract headers
            const headers = [];
            table.querySelectorAll('thead th').forEach(th => {
                headers.push(th.textContent);
            });
            csv.push(headers.join(','));
            
            // Extract rows (only visible ones)
            table.querySelectorAll('tbody tr').forEach(tr => {
                if (tr.style.display !== 'none') {
                    const row = [];
                    tr.querySelectorAll('td').forEach(td => {
                        // Escape quotes and wrap in quotes
                        row.push('"' + td.textContent.trim().replace(/"/g, '""') + '"');
                    });
                    csv.push(row.join(','));
                }
            });
            
            // Create and download CSV file
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'visitor-logs-' + new Date().toISOString().split('T')[0] + '.csv';
            a.click();
            window.URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>
