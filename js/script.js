// ===================================
// Royal Albatross Exports - Main JavaScript
// Interactive Features & Functionality
// ===================================

// ===== Initialize on DOM Load =====
document.addEventListener('DOMContentLoaded', function () {
    // Initialize all features
    initLoader();
    initScrollProgress();
    initNavigation();
    initThemeToggle();
    initBackToTop();
    initCounters();
    initAOS();
    initSmoothScroll();
    initFormValidation();
    initCarousels();
});

// ===== Loading Animation =====
function initLoader() {
    const loader = document.getElementById('loader');

    window.addEventListener('load', function () {
        setTimeout(function () {
            loader.classList.add('hidden');
            setTimeout(function () {
                loader.style.display = 'none';
            }, 500);
        }, 1000);
    });
}

// ===== Scroll Progress Indicator =====
function initScrollProgress() {
    const scrollProgress = document.getElementById('scrollProgress');

    window.addEventListener('scroll', function () {
        const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (window.scrollY / windowHeight) * 100;
        scrollProgress.style.width = scrolled + '%';
    });
}

// ===== Navigation =====
function initNavigation() {
    const navbar = document.getElementById('mainNav');
    const navLinks = document.querySelectorAll('.nav-link');

    // Navbar scroll effect
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Active section highlighting
    const sections = document.querySelectorAll('section[id]');

    function highlightNavigation() {
        const scrollY = window.pageYOffset;

        sections.forEach(section => {
            const sectionHeight = section.offsetHeight;
            const sectionTop = section.offsetTop - 100;
            const sectionId = section.getAttribute('id');

            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + sectionId) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }

    window.addEventListener('scroll', highlightNavigation);

    // Close mobile menu on link click
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse.classList.contains('show')) {
                const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                bsCollapse.hide();
            }
        });
    });
}

// ===== Dark Mode Toggle =====
function initThemeToggle() {
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;

    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    themeToggle.addEventListener('click', function () {
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';

        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);

        // Add transition effect
        document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
    });

    function updateThemeIcon(theme) {
        const icon = themeToggle.querySelector('i');
        if (theme === 'dark') {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
        }
    }
}

// ===== Back to Top Button =====
function initBackToTop() {
    const backToTop = document.getElementById('backToTop');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });

    backToTop.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// ===== Animated Counters =====
function initCounters() {
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200; // Animation speed
    let animated = false;

    function animateCounters() {
        if (animated) return;

        const statsSection = document.querySelector('.stats-section');
        const statsSectionTop = statsSection.offsetTop;
        const statsSectionHeight = statsSection.offsetHeight;
        const scrollY = window.pageYOffset;

        if (scrollY > statsSectionTop - window.innerHeight + statsSectionHeight / 2) {
            animated = true;

            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const increment = target / speed;
                let count = 0;

                const updateCount = () => {
                    count += increment;
                    if (count < target) {
                        counter.textContent = Math.ceil(count);
                        setTimeout(updateCount, 10);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCount();
            });
        }
    }

    window.addEventListener('scroll', animateCounters);
}

// ===== Initialize AOS (Animate On Scroll) =====
function initAOS() {
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        offset: 100,
        delay: 100
    });
}

// ===== Smooth Scroll =====
function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');

    links.forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            // Skip if it's just "#" or a modal/collapse trigger
            if (href === '#' || this.hasAttribute('data-bs-toggle')) {
                return;
            }

            e.preventDefault();

            const target = document.querySelector(href);
            if (target) {
                const offsetTop = target.offsetTop - 80; // Account for fixed navbar

                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ===== Form Validation & Submission =====
function initFormValidation() {
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');

    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(contactForm);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            // Validate form
            if (validateForm(data)) {
                // Show loading state
                const submitBtn = contactForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
                submitBtn.disabled = true;

                // Submit form via AJAX to PHP handler
                fetch('contact-handler.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showMessage('success', data.message);
                            contactForm.reset();

                            // Scroll to message
                            formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        } else {
                            showMessage('error', data.message);
                        }

                        // Reset button
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    })
                    .catch(error => {
                        console.error('Form submission error:', error);
                        showMessage('error', 'An error occurred while sending your message. Please try again or contact us directly at royalalbatrossexports@gmail.com');

                        // Reset button
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
            }
        });
    }

    function validateForm(data) {
        // Name validation
        if (!data.name || data.name.trim().length < 2) {
            showMessage('error', 'Please enter a valid name.');
            return false;
        }

        // Company validation
        if (!data.company || data.company.trim().length < 2) {
            showMessage('error', 'Please enter a valid company name.');
            return false;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!data.email || !emailRegex.test(data.email)) {
            showMessage('error', 'Please enter a valid email address.');
            return false;
        }

        // Phone validation
        const phoneRegex = /^[0-9\s\-\+\(\)]{10,}$/;
        if (!data.phone || !phoneRegex.test(data.phone)) {
            showMessage('error', 'Please enter a valid phone number.');
            return false;
        }

        // Country validation
        if (!data.country || data.country.trim().length < 2) {
            showMessage('error', 'Please enter your country.');
            return false;
        }

        // Product validation
        if (!data.product) {
            showMessage('error', 'Please select a product of interest.');
            return false;
        }

        // Message validation
        if (!data.message || data.message.trim().length < 10) {
            showMessage('error', 'Please enter a detailed message (minimum 10 characters).');
            return false;
        }

        return true;
    }

    function showMessage(type, message) {
        formMessage.className = 'form-message ' + type;
        formMessage.textContent = message;
        formMessage.style.display = 'block';

        // Auto-hide after 5 seconds
        setTimeout(function () {
            formMessage.style.display = 'none';
        }, 5000);
    }
}

// ===== Initialize Carousels =====
function initCarousels() {
    // Hero carousel auto-play
    const heroCarousel = document.getElementById('heroCarousel');
    if (heroCarousel) {
        const carousel = new bootstrap.Carousel(heroCarousel, {
            interval: 5000,
            pause: 'hover',
            wrap: true,
            touch: true
        });
    }

    // Testimonials carousel
    const testimonialsCarousel = document.getElementById('testimonialsCarousel');
    if (testimonialsCarousel) {
        const carousel = new bootstrap.Carousel(testimonialsCarousel, {
            interval: 6000,
            pause: 'hover',
            wrap: true,
            touch: true
        });
    }
}

// ===== Utility Functions =====

// Debounce function for performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle function for scroll events
function throttle(func, limit) {
    let inThrottle;
    return function () {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Check if element is in viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// ===== Performance Optimizations =====

// Lazy load images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Preload critical resources
function preloadResources() {
    const criticalImages = [
        'assets/images/logo_1767183459166.png',
        'assets/images/hero_agriculture_1767183410455.png'
    ];

    criticalImages.forEach(src => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = src;
        document.head.appendChild(link);
    });
}

// Call preload on page load
window.addEventListener('load', preloadResources);

// ===== Analytics & Tracking (Optional) =====
function trackEvent(category, action, label) {
    // Implement your analytics tracking here
    // Example: Google Analytics
    // gtag('event', action, {
    //     'event_category': category,
    //     'event_label': label
    // });

    console.log('Event tracked:', category, action, label);
}

// Track button clicks
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const btnText = this.textContent.trim();
        trackEvent('Button', 'Click', btnText);
    });
});

// Track WhatsApp button clicks
const whatsappBtn = document.querySelector('.whatsapp-float');
if (whatsappBtn) {
    whatsappBtn.addEventListener('click', function () {
        trackEvent('Contact', 'WhatsApp Click', 'Floating Button');
    });
}

// Track form submissions
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function () {
        trackEvent('Form', 'Submit', 'Contact Form');
    });
}

// ===== Error Handling =====
window.addEventListener('error', function (e) {
    console.error('Global error:', e.error);
    // Implement error reporting here if needed
});

// ===== Console Welcome Message =====
console.log('%c Royal Albatross Exports ', 'background: linear-gradient(135deg, #2d7a3e, #4caf50); color: white; font-size: 20px; font-weight: bold; padding: 10px;');
console.log('%c Trusted Quality. Fresh Exports. Global Reach. ', 'color: #2d7a3e; font-size: 14px; font-weight: bold;');
console.log('%c Website developed with ❤️ ', 'color: #666; font-size: 12px;');

// ===== Service Worker Registration (Optional - for PWA) =====
if ('serviceWorker' in navigator) {
    // Uncomment to enable service worker
    /*
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('ServiceWorker registered:', registration);
            })
            .catch(error => {
                console.log('ServiceWorker registration failed:', error);
            });
    });
    */
}

// ===== Export functions for external use =====
window.RoyalAlbatross = {
    trackEvent: trackEvent,
    debounce: debounce,
    throttle: throttle,
    isInViewport: isInViewport
};
