<?php
// Set 404 HTTP status
http_response_code(404);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (file_exists('includes/security.php')) {
    require_once 'includes/security.php';
    if (function_exists('initSecurity')) {
        initSecurity();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Royal Albatross Exports</title>
    <meta name="description" content="The requested page could not be found. Return to Royal Albatross Exports homepage.">
    <meta name="robots" content="noindex, follow">
    <link rel="icon" type="image/png" href="assets/images/logo_1767183459166.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #0d2818;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .error-navbar {
            background: rgba(13, 40, 24, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            padding: 15px 0;
        }
        .error-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            background: radial-gradient(circle at center, rgba(212, 175, 55, 0.15) 0%, rgba(13, 40, 24, 0.98) 70%);
        }
        .error-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(212, 175, 55, 0.25);
            border-radius: 24px;
            padding: 50px 40px;
            max-width: 640px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        .error-badge {
            display: inline-block;
            background: rgba(212, 175, 55, 0.2);
            color: #d4af37;
            border: 1px solid #d4af37;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
        }
        .error-code {
            font-size: clamp(5rem, 12vw, 8.5rem);
            font-weight: 800;
            line-height: 1;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ffffff 30%, #d4af37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .error-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #ffffff;
        }
        .error-desc {
            color: rgba(255, 255, 255, 0.75);
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 35px;
        }
        .btn-gold {
            background: linear-gradient(135deg, #d4af37 0%, #aa820a 100%);
            color: #0d2818;
            font-weight: 700;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #e5c158 0%, #c49914 100%);
            color: #05140b;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
        }
        .btn-outline-light-custom {
            background: transparent;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: 600;
            padding: 14px 28px;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-outline-light-custom:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #d4af37;
            border-color: #d4af37;
            transform: translateY(-2px);
        }
        .quick-links-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 35px;
            margin-bottom: 15px;
        }
        .quick-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }
        .quick-links a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        .quick-links a:hover {
            color: #d4af37;
            text-decoration: underline;
        }
        .error-footer {
            background: #081a10;
            padding: 20px 0;
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body>
    <header class="error-navbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="index.php" class="navbar-brand d-flex align-items-center gap-2 text-decoration-none">
                <img src="assets/images/logo_1767183459166.png" alt="Royal Albatross Exports" height="42">
                <div>
                    <span style="font-weight: 700; color: #ffffff; display: block; line-height: 1.2;">Royal Albatross Exports</span>
                    <span style="font-size: 0.75rem; color: #d4af37; display: block;">Trusted Quality. Fresh Exports. Global Reach</span>
                </div>
            </a>
            <a href="index.php" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Return Home
            </a>
        </div>
    </header>

    <main class="error-wrapper">
        <div class="error-card">
            <div class="error-badge">
                <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i> Error 404
            </div>
            <div class="error-code">404</div>
            <h1 class="error-title">Page Not Found</h1>
            <p class="error-desc">
                The link you followed may be broken, expired, or the page may have been moved. 
                Our export team is always ready to assist you.
            </p>
            
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="index.php" class="btn-gold">
                    <i class="fas fa-home" aria-hidden="true"></i> Back to Homepage
                </a>
                <a href="index.php#contact" class="btn-outline-light-custom">
                    <i class="fas fa-envelope" aria-hidden="true"></i> Contact Our Team
                </a>
            </div>

            <div class="quick-links-title">Popular Destinations</div>
            <div class="quick-links">
                <a href="index.php#products"><i class="fas fa-box-open me-1" aria-hidden="true"></i> Our Products</a>
                <span class="text-white-50">•</span>
                <a href="index.php#about"><i class="fas fa-info-circle me-1" aria-hidden="true"></i> About Us</a>
                <span class="text-white-50">•</span>
                <a href="privacy-policy.php"><i class="fas fa-shield-alt me-1" aria-hidden="true"></i> Privacy Policy</a>
                <span class="text-white-50">•</span>
                <a href="terms.php"><i class="fas fa-file-contract me-1" aria-hidden="true"></i> Terms &amp; Conditions</a>
                <span class="text-white-50">•</span>
                <a href="refund-policy.php"><i class="fas fa-undo me-1" aria-hidden="true"></i> Refund Policy</a>
            </div>
        </div>
    </main>

    <footer class="error-footer">
        <div class="container">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Royal Albatross Exports. All rights reserved. | S.F.349/1, Oornaicker Thottam, Priya Gardens, Poochiyur Road, Coimbatore &ndash; 641031, Tamil Nadu, India</p>
        </div>
    </footer>
</body>
</html>
