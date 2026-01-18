<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Dashboard - Royal Albatross Exports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .security-container {
            max-width: 1600px;
            margin: 0 auto;
        }
        .security-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }
        .security-header h1 {
            margin: 0;
            color: #dc3545;
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
        }
        .stat-card.danger i {
            color: #dc3545;
        }
        .stat-card.warning i {
            color: #ffc107;
        }
        .stat-card.success i {
            color: #28a745;
        }
        .stat-card.info i {
            color: #17a2b8;
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
            margin-bottom: 30px;
        }
        .table-container {
            overflow-x: auto;
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #e9ecef;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            position: sticky;
            top: 0;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        .btn-action {
            padding: 5px 15px;
            font-size: 0.85rem;
            border-radius: 20px;
        }
        .ip-address {
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php
    // Simple password protection
    session_start();
    
    // Change this password
    $ADMIN_PASSWORD = 'royal2026security'; // CHANGE THIS!
    
    // Check if logout is requested
    if (isset($_GET['logout'])) {
        session_destroy();
        header('Location: security-dashboard.php');
        exit;
    }
    
    // Check if login form is submitted
    if (isset($_POST['password'])) {
        if ($_POST['password'] === $ADMIN_PASSWORD) {
            $_SESSION['security_admin_logged_in'] = true;
        } else {
            $loginError = 'Incorrect password!';
        }
    }
    
    // Show login form if not authenticated
    if (!isset($_SESSION['security_admin_logged_in']) || $_SESSION['security_admin_logged_in'] !== true) {
        ?>
        <div class="security-container">
            <div class="security-header text-center">
                <i class="fas fa-shield-alt" style="font-size: 3rem; color: #dc3545;"></i>
                <h1 class="mt-3">Security Dashboard Access</h1>
                <p class="text-muted">Please enter the security admin password</p>
                
                <?php if (isset($loginError)): ?>
                    <div class="alert alert-danger mt-3"><?php echo $loginError; ?></div>
                <?php endif; ?>
                
                <form method="POST" class="mt-4" style="max-width: 400px; margin: 0 auto;">
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" 
                               placeholder="Enter security password" required autofocus>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        exit;
    }
    
    // Handle unblock request
    if (isset($_GET['unblock'])) {
        $ipToUnblock = $_GET['unblock'];
        $blockedIPs = [];
        
        if (file_exists('blocked-ips.json')) {
            $blockedIPs = json_decode(file_get_contents('blocked-ips.json'), true) ?? [];
            if (isset($blockedIPs[$ipToUnblock])) {
                unset($blockedIPs[$ipToUnblock]);
                file_put_contents('blocked-ips.json', json_encode($blockedIPs, JSON_PRETTY_PRINT));
                $successMessage = "IP $ipToUnblock has been unblocked.";
            }
        }
    }
    
    // Load security logs
    $securityLogs = [];
    if (file_exists('security-logs.json')) {
        $securityLogs = json_decode(file_get_contents('security-logs.json'), true) ?? [];
        $securityLogs = array_reverse($securityLogs);
    }
    
    // Load blocked IPs
    $blockedIPs = [];
    if (file_exists('blocked-ips.json')) {
        $blockedIPs = json_decode(file_get_contents('blocked-ips.json'), true) ?? [];
    }
    
    // Calculate statistics
    $totalEvents = count($securityLogs);
    $blockedIPCount = count($blockedIPs);
    
    // Count events by type
    $eventTypes = array_count_values(array_column($securityLogs, 'event_type'));
    
    // Get today's events
    $today = date('Y-m-d');
    $todayEvents = array_filter($securityLogs, function($log) use ($today) {
        return strpos($log['timestamp'], $today) === 0;
    });
    $todayCount = count($todayEvents);
    
    // Count critical events (last 24 hours)
    $oneDayAgo = date('Y-m-d H:i:s', time() - 86400);
    $criticalEvents = array_filter($securityLogs, function($log) use ($oneDayAgo) {
        return $log['timestamp'] > $oneDayAgo && 
               in_array($log['event_type'], ['SQL_INJECTION_ATTEMPT', 'XSS_ATTEMPT', 'PATH_TRAVERSAL_ATTEMPT']);
    });
    $criticalCount = count($criticalEvents);
    ?>

    <div class="security-container">
        <!-- Header -->
        <div class="security-header d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-shield-alt"></i> Security Dashboard</h1>
                <p class="text-muted mb-0">Real-time security monitoring and threat detection</p>
            </div>
            <div>
                <a href="admin-visitor-logs.php" class="btn btn-outline-primary me-2">
                    <i class="fas fa-chart-line"></i> Visitor Logs
                </a>
                <a href="?logout=1" class="btn btn-outline-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card danger">
                <i class="fas fa-exclamation-triangle"></i>
                <h3><?php echo number_format($criticalCount); ?></h3>
                <p>Critical Threats (24h)</p>
            </div>
            <div class="stat-card warning">
                <i class="fas fa-ban"></i>
                <h3><?php echo number_format($blockedIPCount); ?></h3>
                <p>Blocked IPs</p>
            </div>
            <div class="stat-card info">
                <i class="fas fa-bell"></i>
                <h3><?php echo number_format($todayCount); ?></h3>
                <p>Today's Events</p>
            </div>
            <div class="stat-card success">
                <i class="fas fa-shield-alt"></i>
                <h3><?php echo number_format($totalEvents); ?></h3>
                <p>Total Security Events</p>
            </div>
        </div>

        <!-- Blocked IPs -->
        <?php if (!empty($blockedIPs)): ?>
        <div class="logs-container">
            <h4 class="mb-3"><i class="fas fa-ban"></i> Blocked IP Addresses</h4>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>IP Address</th>
                            <th>Reason</th>
                            <th>Blocked At</th>
                            <th>Expires</th>
                            <th>User Agent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blockedIPs as $ip => $info): ?>
                        <tr>
                            <td class="ip-address text-danger"><?php echo htmlspecialchars($ip); ?></td>
                            <td><?php echo htmlspecialchars($info['reason']); ?></td>
                            <td><?php echo htmlspecialchars($info['blocked_at']); ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $info['expires']); ?></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo htmlspecialchars($info['user_agent']); ?>
                            </td>
                            <td>
                                <a href="?unblock=<?php echo urlencode($ip); ?>" 
                                   class="btn btn-sm btn-success btn-action"
                                   onclick="return confirm('Unblock this IP address?');">
                                    <i class="fas fa-unlock"></i> Unblock
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- Security Logs -->
        <div class="logs-container">
            <h4 class="mb-3"><i class="fas fa-list"></i> Security Event Log</h4>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Timestamp</th>
                            <th>Event Type</th>
                            <th>IP Address</th>
                            <th>Request URI</th>
                            <th>Details</th>
                            <th>User Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($securityLogs as $index => $log): 
                            $isCritical = in_array($log['event_type'], ['SQL_INJECTION_ATTEMPT', 'XSS_ATTEMPT', 'PATH_TRAVERSAL_ATTEMPT']);
                            $badgeClass = $isCritical ? 'bg-danger' : 'bg-warning';
                        ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($log['timestamp']); ?></td>
                            <td>
                                <span class="badge <?php echo $badgeClass; ?>">
                                    <?php echo htmlspecialchars($log['event_type']); ?>
                                </span>
                            </td>
                            <td class="ip-address"><?php echo htmlspecialchars($log['ip']); ?></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;" 
                                title="<?php echo htmlspecialchars($log['request_uri']); ?>">
                                <?php echo htmlspecialchars($log['request_uri']); ?>
                            </td>
                            <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis;" 
                                title="<?php echo htmlspecialchars($log['details']); ?>">
                                <?php echo htmlspecialchars($log['details']); ?>
                            </td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;" 
                                title="<?php echo htmlspecialchars($log['user_agent']); ?>">
                                <?php echo htmlspecialchars($log['user_agent']); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($securityLogs)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-shield-alt fa-3x mb-3"></i>
                                <p>No security events logged yet</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
