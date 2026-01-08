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
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            position: sticky;
            top: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            z-index: 10;
        }
        thead th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        tbody tr {
            border-bottom: 1px solid #e9ecef;
            transition: background 0.2s;
        }
        tbody tr:hover {
            background: #f8f9fa;
        }
        tbody td {
            padding: 12px 15px;
            color: #333;
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
                        <input type="password" name="password" class="form-control" placeholder="Enter admin password" required autofocus>
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
    $browsers = array_count_values(array_column($visitorLogs, 'browser'));
    $topBrowser = $browsers ? array_keys($browsers, max($browsers))[0] : 'N/A';
    $operatingSystems = array_count_values(array_column($visitorLogs, 'os'));
    $topOS = $operatingSystems ? array_keys($operatingSystems, max($operatingSystems))[0] : 'N/A';
    
    // Get today's visits
    $today = date('Y-m-d');
    $todayVisits = array_filter($visitorLogs, function($log) use ($today) {
        return strpos($log['timestamp'], $today) === 0;
    });
    $todayCount = count($todayVisits);
    ?>

    <div class="admin-container">
        <!-- Header -->
        <div class="admin-header d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-chart-line"></i> Visitor Analytics Dashboard</h1>
                <p class="text-muted mb-0">Real-time visitor tracking and IP monitoring</p>
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

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3><?php echo number_format($totalVisits); ?></h3>
                <p>Total Visits</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-user-check"></i>
                <h3><?php echo number_format($uniqueIPs); ?></h3>
                <p>Unique Visitors</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar-day"></i>
                <h3><?php echo number_format($todayCount); ?></h3>
                <p>Today's Visits</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-globe"></i>
                <h3><?php echo $topBrowser; ?></h3>
                <p>Top Browser</p>
            </div>
        </div>

        <!-- Logs Table -->
        <div class="logs-container">
            <div class="filter-section">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-3 mb-md-0"><i class="fas fa-list"></i> Visitor Logs</h4>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="searchBox" class="search-box" placeholder="Search by IP, browser, OS...">
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table id="visitorTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Timestamp</th>
                            <th>IP Address</th>
                            <th>Browser</th>
                            <th>OS</th>
                            <th>Referer</th>
                            <th>Page</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visitorLogs as $index => $log): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($log['timestamp']); ?></td>
                            <td class="ip-address"><?php echo htmlspecialchars($log['ip_address']); ?></td>
                            <td><span class="badge bg-primary"><?php echo htmlspecialchars($log['browser']); ?></span></td>
                            <td><span class="badge bg-success"><?php echo htmlspecialchars($log['os']); ?></span></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($log['referer']); ?>">
                                <?php echo htmlspecialchars($log['referer']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($log['request_uri']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($visitorLogs)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
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
        // Search functionality
        document.getElementById('searchBox').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#visitorTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Export to CSV
        function exportToCSV() {
            const table = document.getElementById('visitorTable');
            let csv = [];
            
            // Headers
            const headers = [];
            table.querySelectorAll('thead th').forEach(th => {
                headers.push(th.textContent);
            });
            csv.push(headers.join(','));
            
            // Rows
            table.querySelectorAll('tbody tr').forEach(tr => {
                if (tr.style.display !== 'none') {
                    const row = [];
                    tr.querySelectorAll('td').forEach(td => {
                        row.push('"' + td.textContent.trim().replace(/"/g, '""') + '"');
                    });
                    csv.push(row.join(','));
                }
            });
            
            // Download
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
