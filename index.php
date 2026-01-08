<?php
// Track visitor information
include_once 'includes/visitor-tracker.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Royal Albatross Exports - Premium Agricultural & Flower Exporter from Coimbatore, India. Trusted Quality. Fresh Exports. Global Reach. 16+ years of excellence in export-grade produce.">
    <meta name="keywords"
        content="agricultural exports, flower exports, organic products, agro commodities, wholesale flowers, Coimbatore exports, India agriculture">
    <meta name="author" content="Royal Albatross Exports">
    <meta property="og:title" content="Royal Albatross Exports - Premium Agricultural & Flower Exporter">
    <meta property="og:description"
        content="Trusted Quality. Fresh Exports. Global Reach. 16+ years of excellence in agricultural and flower exports.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://royalalbatrossexport.com">
    <title>Royal Albatross Exports - Premium Agricultural & Flower Exporter | Coimbatore, India</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo_1767183459166.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/new-features.css">
</head>

<body>
    <!-- Welcome Modal -->
    <?php include 'includes/welcome-modal.php'; ?>
    
    <!-- Loading Animation -->
    <div id="loader" class="loader-wrapper">
        <div class="loader-content">
            <img src="assets/images/logo_royal_AlbertoExports.png" alt="Royal Albatross Exports" class="loader-logo">
            <div class="loader-spinner"></div>
            <p class="loader-text">Loading Excellence...</p>
        </div>
    </div>

    <!-- Scroll Progress Indicator -->
    <div class="scroll-progress" id="scrollProgress"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#home">
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
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="#why-us">Why Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item">
                        <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Slider -->
    <section id="home" class="hero-section">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/hero_agriculture_1767183410455.png" class="d-block w-100"
                        alt="Fresh Agricultural Exports">
                    <div class="carousel-caption">
                        <div class="container">
                            <h1 class="display-3 fw-bold" data-aos="fade-up">Fresh Agricultural Exports</h1>
                            <p class="lead" data-aos="fade-up" data-aos-delay="100">Reliable sourcing and strict quality
                                checks</p>
                            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                                <a href="#products" class="btn btn-primary btn-lg me-3">Explore Products</a>
                                <a href="#contact" class="btn btn-outline-light btn-lg">Get Quote</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/images/hero_flowers_1767183425528.png" class="d-block w-100"
                        alt="Premium Flower Shipments">
                    <div class="carousel-caption">
                        <div class="container">
                            <h1 class="display-3 fw-bold" data-aos="fade-up">Premium Flower Shipments</h1>
                            <p class="lead" data-aos="fade-up" data-aos-delay="100">Fresh cut flowers delivered
                                worldwide</p>
                            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                                <a href="#products" class="btn btn-primary btn-lg me-3">Explore Products</a>
                                <a href="#contact" class="btn btn-outline-light btn-lg">Get Quote</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/images/hero_organic_1767183442424.png" class="d-block w-100"
                        alt="Organic Agro Solutions">
                    <div class="carousel-caption">
                        <div class="container">
                            <h1 class="display-3 fw-bold" data-aos="fade-up">Organic Agro Solutions</h1>
                            <p class="lead" data-aos="fade-up" data-aos-delay="100">Safe, sustainable, export-ready</p>
                            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                                <a href="#products" class="btn btn-primary btn-lg me-3">Explore Products</a>
                                <a href="#contact" class="btn btn-outline-light btn-lg">Get Quote</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item hero-video-slide">
                    <video class="hero-video" autoplay muted loop playsinline>
                        <source src="assets/videos/hero-video.mp4" type="video/mp4">
                        <source src="assets/videos/hero-video.webm" type="video/webm">
                        <!-- Fallback image if video doesn't load -->
                        <img src="assets/images/hero_agriculture_1767183410455.png" class="d-block w-100"
                            alt="Royal Albatross Exports">
                    </video>
                    <div class="carousel-caption">
                        <div class="container">
                            <h1 class="display-3 fw-bold" data-aos="fade-up">Excellence in Every Export</h1>
                            <p class="lead" data-aos="fade-up" data-aos-delay="100">Watch our journey from farm to
                                global markets</p>
                            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                                <a href="#products" class="btn btn-primary btn-lg me-3">Explore Products</a>
                                <a href="#contact" class="btn btn-outline-light btn-lg">Get Quote</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- YouTube Video Slide -->
                <div class="carousel-item hero-youtube-slide">
                    <div class="youtube-video-wrapper">
                        <iframe class="hero-youtube-video"
                            src="https://www.youtube.com/embed/LGF33NN4B8U?autoplay=1&mute=1&loop=1&playlist=LGF33NN4B8U&controls=0&showinfo=0&rel=0&modestbranding=1"
                            title="Royal Albatross Exports Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope;
                            picture-in-picture" allowfullscreen>
                        </iframe>
                    </div>
                    <div class="carousel-caption">
                        <div class="container">
                            <h1 class="display-3 fw-bold" data-aos="fade-up">Our Story on YouTube</h1>
                            <p class="lead" data-aos="fade-up" data-aos-delay="100">Discover our commitment to quality
                                and excellence</p>
                            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                                <a href="#products" class="btn btn-primary btn-lg me-3">Explore Products</a>
                                <a href="#contact" class="btn btn-outline-light btn-lg">Get Quote</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="stat-number" data-count="16">0</h3>
                        <p class="stat-label">Years Experience</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3 class="stat-number" data-count="25">0</h3>
                        <p class="stat-label">Countries Served</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="stat-number" data-count="500">0</h3>
                        <p class="stat-label">Happy Clients</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <h3 class="stat-number" data-count="10000">0</h3>
                        <p class="stat-label">Shipments Delivered</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image">
                        <img src="assets/images/hero_agriculture_1767183410455.png" alt="About Royal Albatross Exports"
                            class="img-fluid rounded-4">
                        <div class="experience-badge">
                            <h3>16+</h3>
                            <p>Years of Excellence</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="about-content">
                        <span class="section-subtitle">About Us</span>
                        <h2 class="section-title">Trusted Quality. Fresh Exports. Global Reach.</h2>
                        <p class="section-description">
                            Royal Albatross Exports is a premier exporter of agricultural, agro, and flower products
                            based in Coimbatore, Tamil Nadu. With over 16 years of experience in the export industry, we
                            have built a reputation for delivering consistent quality, reliable shipping, and
                            maintaining long-term relationships with global buyers.
                        </p>
                        <p class="section-description">
                            Our commitment to excellence is reflected in every shipment we make. From farm to
                            destination, we ensure strict quality control, proper packaging, and timely delivery. We
                            work directly with farmers and suppliers to bring you the freshest, highest-quality products
                            at competitive prices.
                        </p>
                        <div class="about-features">
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>ISO Certified Quality Standards</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Direct Farm Sourcing</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Global Logistics Network</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>24/7 Customer Support</span>
                            </div>
                        </div>
                        <a href="#contact" class="btn btn-primary btn-lg mt-4">Get in Touch</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <?php include 'includes/products-section.php'; ?>

    <!-- Why Choose Us Section -->
    <section id="why-us" class="why-us-section section-padding">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-subtitle">Why Choose Us</span>
                <h2 class="section-title">Your Trusted Export Partner</h2>
                <p class="section-description">We deliver excellence in every aspect of our service</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3>Consistent Quality</h3>
                        <p>Strict grading and inspection processes ensure only the best products reach you.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3>Reliable Shipping</h3>
                        <p>Timely dispatch through trusted logistics partners worldwide.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h3>Competitive Pricing</h3>
                        <p>Direct sourcing from farms ensures best prices for premium quality.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h3>Custom Solutions</h3>
                        <p>Packaging and quantities tailored to your specific business needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <?php include 'includes/testimonials-section.php'; ?>

    <!-- FAQ Section -->
    <?php include 'includes/faq-section.php'; ?>

    <!-- Contact Section -->
    <?php include 'includes/contact-section.php'; ?>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/919442229082" class="whatsapp-float" target="_blank" aria-label="Contact us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Product Modals -->
    <?php include 'includes/product-modals.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JS -->
    <script src="js/script.js"></script>
    <script src="js/new-features.js"></script>
</body>

</html>
