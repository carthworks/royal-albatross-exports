<section id="contact" class="contact-section section-padding">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-subtitle">Contact Us</span>
            <h2 class="section-title">Get in Touch</h2>
            <p class="section-description">Ready to start your export journey? Contact us today</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-right">
                <div class="contact-info">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Our Location</h4>
                        <p>S.F.349/1, Oornaicker Thottam, Priya Gardens, Poochiyur Road, Coimbatore-641031, Tamil Nadu, India
                        </p>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4>Phone</h4>
                        <p><a href="tel:+919442229082">+91 94422 29082, +91 63834 24438</a>
                        </p>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email</h4>
                        <p><a href="mailto:royalalbatrossexports@gmail.com">royalalbatrossexports@gmail.com</a>
                        <a href="mailto:info@royalalbatrossexports.in">info@royalalbatrossexports.in</a>
                    </p>
                    </div>
                    <div class="social-links">
                        <a href="https://www.facebook.com/RoyalAlbatrossExports" target="_blank"
                            class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/royalalbatrossexports" target="_blank"
                            class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/royalalbatrossexports" target="_blank"
                            class="social-link">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.youtube.com/@RoyalAlbatrossExports" target="_blank"
                            class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8" data-aos="fade-left">
                <form id="contactForm" class="contact-form" action="contact-handler.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company">Company Name *</label>
                                <input type="text" class="form-control" id="company" name="company" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country *</label>
                                <input type="text" class="form-control" id="country" name="country" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product">Product Interest *</label>
                                <select class="form-control" id="product" name="product" required>
                                    <option value="">Select Product</option>
                                    <option value="roses">Fresh Cut Roses &amp; Flowers</option>
                                    <option value="honey">Pure Organic Wild Honey</option>
                                    <option value="coconuts">Fresh Export Coconuts</option>
                                    <option value="agricultural">Agricultural Produce &amp; Vegetables</option>
                                    <option value="agro">Agro Commodities &amp; Spices</option>
                                    <option value="custom">Custom Export Sourcing</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="quantity">Estimated Quantity</label>
                                <input type="text" class="form-control" id="quantity" name="quantity"
                                    placeholder="e.g., 5 tons, 1000 stems">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="message">Message / Requirements *</label>
                                <textarea class="form-control" id="message" name="message" rows="5"
                                    required></textarea>
                            </div>
                        </div>
                        <!-- Honeypot field for spam protection -->
                        <input type="text" name="website" style="display:none;">
                        <!-- Hidden timezone field -->
                        <input type="hidden" name="timezone" id="timezone">
                        <!-- Human verification checkbox -->
                        <div class="col-12">
                            <div class="form-check" style="padding: 15px; background: #f8f9fa; border-radius: 8px; border: 2px solid #e9ecef;">
                                <input class="form-check-input" type="checkbox" id="humanCheck" name="human_check" value="yes" required style="width: 20px; height: 20px; margin-top: 2px;">
                                <label class="form-check-label" for="humanCheck" style="margin-left: 10px; font-weight: 500; cursor: pointer;">
                                    <i class="fas fa-shield-alt text-success me-2"></i>I am human and agree to be contacted regarding my inquiry
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-paper-plane me-2" aria-hidden="true"></i>Send Inquiry
                            </button>
                            <p class="text-muted small mt-2 text-center">
                                <i class="fas fa-lock me-1" aria-hidden="true"></i>
                                Your information is used only to respond to your inquiry.
                                <a href="privacy-policy.php" target="_blank">Privacy Policy</a>
                            </p>
                        </div>
                    </div>
                </form>
                <div id="formMessage" class="form-message mt-3"></div>
            </div>
        </div>
        <!-- Google Maps -->
        <div class="map-container mt-5" data-aos="fade-up">
            <iframe
                src="https://www.google.com/maps/embed?q=S.F.349%2F1%2C+Oornaicker+Thottam%2C+Priya+Gardens%2C+Poochiyur+Road%2C+Coimbatore%2C+Tamil+Nadu+641031%2C+India&output=embed"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Royal Albatross Exports location on Google Maps">
            </iframe>
        </div>
    </div>
</section>

<script>
// Timezone Capture for Contact Form
document.addEventListener('DOMContentLoaded', function () {
    const timezoneField = document.getElementById('timezone');
    if (timezoneField) {
        try {
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            const offset = new Date().getTimezoneOffset();
            const offsetHours = Math.abs(offset / 60);
            const offsetSign = offset > 0 ? '-' : '+';
            timezoneField.value = `${timezone} (UTC${offsetSign}${offsetHours})`;
        } catch (e) {
            timezoneField.value = 'Unable to detect';
        }
    }
});
</script>

