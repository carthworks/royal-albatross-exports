// ===================================
// Royal Albatross Exports - New Features JavaScript
// Advanced Interactive Features
// ===================================

// ===== Particle Background Effect =====
function createParticles() {
    const particlesContainer = document.createElement('div');
    particlesContainer.className = 'particles-bg';

    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        heroSection.style.position = 'relative';
        heroSection.appendChild(particlesContainer);

        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particlesContainer.appendChild(particle);
        }
    }
}

// ===== Parallax Scrolling Effect =====
function initParallax() {
    const parallaxElements = document.querySelectorAll('[data-parallax]');

    window.addEventListener('scroll', function () {
        parallaxElements.forEach(element => {
            const speed = element.getAttribute('data-parallax') || 0.5;
            const yPos = -(window.pageYOffset * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });
}

// ===== Magnetic Cursor Effect for Buttons =====
function initMagneticButtons() {
    const buttons = document.querySelectorAll('.btn, .magnetic-btn');

    buttons.forEach(button => {
        button.addEventListener('mousemove', function (e) {
            const rect = button.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;

            button.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
        });

        button.addEventListener('mouseleave', function () {
            button.style.transform = 'translate(0, 0)';
        });
    });
}

// ===== Typing Animation for Hero Text =====
function initTypingAnimation() {
    const typingElements = document.querySelectorAll('.typing-text');

    typingElements.forEach(element => {
        const text = element.textContent;
        element.textContent = '';
        element.style.display = 'inline-block';

        let i = 0;
        const typeWriter = () => {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        };

        // Start typing when element is in viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    typeWriter();
                    observer.unobserve(element);
                }
            });
        });

        observer.observe(element);
    });
}

// ===== Image Lightbox Gallery =====
function initLightbox() {
    const productImages = document.querySelectorAll('.product-image img');

    productImages.forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function (e) {
            if (!e.target.closest('.btn-view')) {
                createLightbox(this.src, this.alt);
            }
        });
    });
}

function createLightbox(src, alt) {
    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox-overlay';
    lightbox.innerHTML = `
        <div class="lightbox-content">
            <button class="lightbox-close">&times;</button>
            <img src="${src}" alt="${alt}">
            <div class="lightbox-caption">${alt}</div>
        </div>
    `;

    document.body.appendChild(lightbox);
    document.body.style.overflow = 'hidden';

    // Add styles
    const style = document.createElement('style');
    style.textContent = `
        .lightbox-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }
        .lightbox-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            animation: zoomIn 0.3s ease;
        }
        .lightbox-content img {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
            border-radius: 10px;
        }
        .lightbox-close {
            position: absolute;
            top: -40px;
            right: 0;
            background: none;
            border: none;
            color: white;
            font-size: 40px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .lightbox-close:hover {
            transform: rotate(90deg);
        }
        .lightbox-caption {
            color: white;
            text-align: center;
            margin-top: 15px;
            font-size: 18px;
        }
    `;
    document.head.appendChild(style);

    // Close on click
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox || e.target.classList.contains('lightbox-close')) {
            closeLightbox(lightbox);
        }
    });

    // Close on ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeLightbox(lightbox);
        }
    });
}

function closeLightbox(lightbox) {
    lightbox.style.animation = 'fadeOut 0.3s ease';
    setTimeout(() => {
        lightbox.remove();
        document.body.style.overflow = '';
    }, 300);
}

// ===== Scroll Reveal Animation =====
function initScrollReveal() {
    const revealElements = document.querySelectorAll('.reveal');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                revealObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15
    });

    revealElements.forEach(element => {
        revealObserver.observe(element);
    });
}

// ===== Stagger Animation for Lists =====
function initStaggerAnimation() {
    const staggerContainers = document.querySelectorAll('[data-stagger]');

    staggerContainers.forEach(container => {
        const children = container.children;
        Array.from(children).forEach((child, index) => {
            child.classList.add('stagger-item');
            child.style.animationDelay = `${index * 0.1}s`;
        });
    });
}

// ===== Smooth Number Counter with Easing =====
function animateValue(element, start, end, duration, suffix = '') {
    const range = end - start;
    const increment = range / (duration / 16);
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
            current = end;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current) + suffix;
    }, 16);
}

// ===== Tooltip Initialization =====
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// ===== Copy to Clipboard Function =====
function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(() => {
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.classList.add('success');

        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('success');
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy:', err);
    });
}

// ===== Reading Progress Bar =====
function initReadingProgress() {
    const progressBar = document.createElement('div');
    progressBar.className = 'reading-progress';
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #2d7a3e, #4caf50);
        z-index: 9999;
        transition: width 0.1s ease;
    `;
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (window.scrollY / windowHeight) * 100;
        progressBar.style.width = scrolled + '%';
    });
}

// ===== Lazy Loading for Background Images =====
function initLazyBackgrounds() {
    const lazyBackgrounds = document.querySelectorAll('[data-bg]');

    const bgObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                element.style.backgroundImage = `url(${element.dataset.bg})`;
                element.removeAttribute('data-bg');
                bgObserver.unobserve(element);
            }
        });
    });

    lazyBackgrounds.forEach(bg => {
        bgObserver.observe(bg);
    });
}

// ===== Intersection Observer for Animations =====
function initIntersectionAnimations() {
    const animatedElements = document.querySelectorAll('[data-animate]');

    const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const animation = entry.target.dataset.animate;
                entry.target.classList.add(animation);
                animationObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.2
    });

    animatedElements.forEach(element => {
        animationObserver.observe(element);
    });
}

// ===== Custom Cursor Effect =====
function initCustomCursor() {
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    cursor.style.cssText = `
        width: 20px;
        height: 20px;
        border: 2px solid #2d7a3e;
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.2s ease;
        display: none;
    `;
    document.body.appendChild(cursor);

    document.addEventListener('mousemove', (e) => {
        cursor.style.display = 'block';
        cursor.style.left = e.clientX - 10 + 'px';
        cursor.style.top = e.clientY - 10 + 'px';
    });

    document.querySelectorAll('a, button').forEach(element => {
        element.addEventListener('mouseenter', () => {
            cursor.style.transform = 'scale(1.5)';
            cursor.style.borderColor = '#d4af37';
        });

        element.addEventListener('mouseleave', () => {
            cursor.style.transform = 'scale(1)';
            cursor.style.borderColor = '#2d7a3e';
        });
    });
}

// ===== Preloader with Progress =====
function initPreloaderProgress() {
    const preloader = document.querySelector('.loader-wrapper');
    if (!preloader) return;

    let progress = 0;
    const progressText = preloader.querySelector('.loader-text');

    const interval = setInterval(() => {
        progress += Math.random() * 30;
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);
        }
        if (progressText) {
            progressText.textContent = `Loading... ${Math.floor(progress)}%`;
        }
    }, 200);
}

// ===== Scroll-triggered Animations =====
function initScrollTriggers() {
    const triggers = document.querySelectorAll('[data-scroll-trigger]');

    triggers.forEach(trigger => {
        const targetSelector = trigger.dataset.scrollTrigger;
        const target = document.querySelector(targetSelector);

        if (target) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        trigger.classList.add('triggered');
                    }
                });
            });

            observer.observe(target);
        }
    });
}

// ===== Cookie Consent Banner =====
function initCookieConsent() {
    if (localStorage.getItem('cookieConsent')) return;

    const banner = document.createElement('div');
    banner.className = 'cookie-banner';
    banner.innerHTML = `
        <div class="cookie-content">
            <p>We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.</p>
            <button class="btn btn-primary btn-sm" id="acceptCookies">Accept</button>
        </div>
    `;

    const style = document.createElement('style');
    style.textContent = `
        .cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(45, 122, 62, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px;
            z-index: 9999;
            animation: slideInUp 0.5s ease;
        }
        .cookie-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }
        .cookie-content p {
            color: white;
            margin: 0;
            flex: 1;
        }
        @keyframes slideInUp {
            from {
                transform: translateY(100%);
            }
            to {
                transform: translateY(0);
            }
        }
    `;

    document.head.appendChild(style);
    document.body.appendChild(banner);

    document.getElementById('acceptCookies').addEventListener('click', () => {
        localStorage.setItem('cookieConsent', 'true');
        banner.style.animation = 'slideInUp 0.5s ease reverse';
        setTimeout(() => banner.remove(), 500);
    });
}

// ===== Initialize All New Features =====
document.addEventListener('DOMContentLoaded', function () {
    // Initialize features
    createParticles();
    initParallax();
    initMagneticButtons();
    initTypingAnimation();
    initLightbox();
    initScrollReveal();
    initStaggerAnimation();
    initTooltips();
    initLazyBackgrounds();
    initIntersectionAnimations();
    initPreloaderProgress();
    initScrollTriggers();
    initCookieConsent();

    // Optional: Custom cursor (uncomment if desired)
    // initCustomCursor();
});

// ===== Performance Monitoring =====
if (window.performance && window.performance.timing) {
    window.addEventListener('load', function () {
        setTimeout(function () {
            const perfData = window.performance.timing;
            const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
            console.log('Page Load Time:', pageLoadTime + 'ms');

            // Track performance
            if (pageLoadTime > 3000) {
                console.warn('Page load time is slow. Consider optimization.');
            }
        }, 0);
    });
}

// ===== Service Worker for Offline Support =====
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        // Uncomment to enable offline support
        /*
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('SW registered:', registration);
            })
            .catch(error => {
                console.log('SW registration failed:', error);
            });
        */
    });
}

// ===== Export Additional Functions =====
window.RoyalAlbatrossExtended = {
    copyToClipboard: copyToClipboard,
    animateValue: animateValue,
    createLightbox: createLightbox
};

// ===== Console Easter Egg =====
console.log('%c🌾 Looking for something? ', 'background: #2d7a3e; color: white; font-size: 16px; padding: 5px 10px; border-radius: 5px;');
console.log('%c💼 We\'re hiring! Contact us at royalalbatrossexports@gmail.com ', 'color: #d4af37; font-size: 12px;');
