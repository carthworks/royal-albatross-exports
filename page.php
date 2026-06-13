<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php-errors.log');

ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    if (file_exists('includes/security.php')) {
        require_once 'includes/security.php';
        if (function_exists('initSecurity')) {
            initSecurity();
        }
    }
    if (file_exists('includes/visitor-tracker.php')) {
        require_once 'includes/visitor-tracker.php';
    }
} catch (Exception $e) {
    error_log("Error initializing routing systems: " . $e->getMessage());
}

// Get and sanitize slug
$slug = isset($_GET['slug']) ? preg_replace('/[^a-zA-Z0-9-_]/', '', $_GET['slug']) : '';

// Load page details
$page = null;
$pagesFile = 'data/pages.json';

if (!empty($slug) && file_exists($pagesFile)) {
    $pagesData = json_decode(file_get_contents($pagesFile), true) ?? [];
    if (isset($pagesData[$slug])) {
        $candidatePage = $pagesData[$slug];
        
        // Show page if published, or if admin is logged in (for previewing drafts)
        $isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
        if (($candidatePage['status'] ?? 'draft') === 'published' || $isAdmin) {
            $page = $candidatePage;
        }
    }
}

// If page is not found, render premium 404 page
if (!$page) {
    header("HTTP/1.1 404 Not Found");
    render404();
    exit;
}

// Helper to render 404
function render404() {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page Not Found | Royal Albatross Exports</title>
        <link rel="icon" type="image/png" href="assets/images/logo_1767183459166.png">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/new-features.css">
        <style>
            .error-section {
                min-height: 80vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, var(--dark-green) 0%, #153e20 100%);
                color: white;
                position: relative;
                overflow: hidden;
            }
            .error-card {
                background: rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.15);
                border-radius: 20px;
                padding: 50px 30px;
                max-width: 600px;
                width: 100%;
                text-align: center;
                box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            }
            .error-icon {
                font-size: 5rem;
                color: var(--gold);
                margin-bottom: 25px;
                animation: float 4s ease-in-out infinite;
            }
            .error-code {
                font-size: 7rem;
                font-weight: 800;
                line-height: 1;
                margin-bottom: 15px;
                background: linear-gradient(135deg, #fff 0%, var(--gold) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
        </style>
    </head>
    <body>
        <section class="error-section">
            <div class="container d-flex justify-content-center">
                <div class="error-card" data-aos="fade-up">
                    <div class="error-icon">
                        <i class="fas fa-compass"></i>
                    </div>
                    <div class="error-code">404</div>
                    <h2 class="h3 mb-3 fw-bold">Page Not Found</h2>
                    <p class="text-white-50 mb-4">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                    <a href="index.php" class="btn btn-primary btn-lg px-5" style="background: var(--gold); border-color: var(--gold); color: var(--dark-green); font-weight: 600;">
                        <i class="fas fa-home me-2"></i> Back to Homepage
                    </a>
                </div>
            </div>
        </section>
    </body>
    </html>
    <?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($page['description'] ?? ''); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page['keywords'] ?? ''); ?>">
    <meta name="author" content="Royal Albatross Exports">
    <title><?php echo htmlspecialchars($page['title']); ?> | Royal Albatross Exports</title>

    <!-- Favicon -->
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
    <link rel="stylesheet" href="css/new-features.css">
    
    <style>
        /* Specific content styles for dynamic content */
        .dynamic-content-wrapper {
            line-height: 1.8;
            font-size: 1.1rem;
            color: var(--text-dark, #333333);
        }
        .dynamic-content-wrapper h1, 
        .dynamic-content-wrapper h2, 
        .dynamic-content-wrapper h3, 
        .dynamic-content-wrapper h4 {
            color: var(--dark-green);
            font-weight: 700;
            margin-top: 1.8rem;
            margin-bottom: 1rem;
        }
        .dynamic-content-wrapper h1 { font-size: 2.2rem; }
        .dynamic-content-wrapper h2 { font-size: 1.8rem; }
        .dynamic-content-wrapper h3 { font-size: 1.5rem; }
        
        .dynamic-content-wrapper p {
            margin-bottom: 1.5rem;
        }
        .dynamic-content-wrapper ul, 
        .dynamic-content-wrapper ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }
        .dynamic-content-wrapper li {
            margin-bottom: 0.5rem;
        }
        
        /* Breadcrumbs styling override */
        .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255,255,255,0.6);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav" style="background: rgba(15, 61, 31, 0.95); backdrop-filter: blur(10px); box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/images/logo_1767183459166.png" alt="Royal Albatross Exports" class="logo-img">
                <div class="brand-info">
                    <span class="brand-text">Royal Albatross Exports</span>
                    <span class="brand-tagline">Trusted Quality. Fresh Exports. Global Reach</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="index.php#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#why-us">Why Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Hero Banner -->
    <section class="page-hero-banner" style="background: linear-gradient(135deg, var(--dark-green) 0%, #17542b 100%); padding-top: 160px; padding-bottom: 80px; position: relative; overflow: hidden;">
        <div class="container text-center" style="position: relative; z-index: 2;">
            <h1 class="display-4 fw-bold text-white mb-3"><?php echo htmlspecialchars($page['title']); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="index.php" style="color: rgba(255,255,255,0.7); text-decoration: none;">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page"><?php echo htmlspecialchars($page['title']); ?></li>
                </ol>
            </nav>
        </div>
        <div class="banner-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 50% 50%, rgba(212, 175, 55, 0.12) 0%, transparent 85%);"></div>
    </section>

    <!-- Main Content Area -->
    <main class="py-5" style="background: #fdfdfd; min-height: 450px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Glassmorphism card for content wrapper -->
                    <div class="card border-0 shadow rounded-4 p-4 p-md-5" style="background: #ffffff; box-shadow: 0 10px 40px rgba(0,0,0,0.04) !important;">
                        
                        <?php if (isset($page['status']) && $page['status'] === 'draft'): ?>
                            <div class="alert alert-warning border-0 rounded-3 mb-4 d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div><strong>Preview Mode:</strong> This page is currently a draft and is visible only to you (admin logged in).</div>
                            </div>
                        <?php endif; ?>

                        <article class="dynamic-content-wrapper">
                            <?php 
                            // Render page content directly. 
                            // Note: Content is stored as safe HTML output from Quill.js editor.
                            echo $page['content']; 
                            ?>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6383424438" class="whatsapp-float" target="_blank" aria-label="Contact us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
