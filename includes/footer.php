<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-about">
                    <img src="assets/images/logo_1767183459166.png" alt="Royal Albatross Exports"
                        class="footer-logo">
                    <h3>Royal Albatross Exports</h3>
                    <p>Your trusted partner for premium agricultural and flower exports. Delivering quality and
                        freshness worldwide since 2009.</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#why-us">Why Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-links">
                    <h4>Products</h4>
                    <ul>
                        <li><a href="#products">Agricultural Products</a></li>
                        <li><a href="#products">Agro Products</a></li>
                        <li><a href="#products">Flower Products</a></li>
                        <li><a href="#products">Organic Products</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-contact">
                    <h4>Contact Info</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> +91 94422 29082</li>
                        <li><i class="fas fa-envelope"></i> royalalbatrossexports@gmail.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Coimbatore, Tamil Nadu, India</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <?php
            // Include visitor counter
            $visitorData = include 'visitor-counter.php';
            ?>
            <p>&copy; <?php echo date('Y'); ?> Royal Albatross Exports. All rights reserved. | Designed with <i
                    class="fas fa-heart"></i> for Excellence</p>
            <p class="visitor-counter" style="font-size: 0.85rem; opacity: 0.7; margin-top: 8px;">
                <i class="fas fa-eye"></i> <?php echo number_format($visitorData['total_visits']); ?> visits
                <span style="margin: 0 8px;">•</span>
                <i class="fas fa-users"></i> <?php echo number_format($visitorData['unique_visitors']); ?> visitors
            </p>
        </div>
    </div>
</footer>
