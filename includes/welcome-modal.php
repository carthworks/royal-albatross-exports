<!-- Welcome Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content welcome-modal-content">
            <button type="button" class="btn-close welcome-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="welcome-modal-inner">
                    <div class="welcome-image-container">
                        <img src="assets/images/lord_siva.jpeg" 
                             alt="Lord Shiva Blessing" 
                             class="welcome-image"
                             onerror="this.onerror=null; this.src='assets/images/logo_1767183459166.png'; this.style.maxHeight='200px';"
                             loading="eager">
                        <div class="divine-glow"></div>
                    </div>
                    <div class="welcome-content">
                        <div class="welcome-icon">
                            <i class="fas fa-om"></i>
                        </div>
                        <h2 class="welcome-title">🙏 Divine Blessings 🙏</h2>
                        <p class="welcome-message">
                            May Lord Shiva bless our business with prosperity, success, and divine grace.
                        </p>
                        <p class="welcome-submessage">
                            Welcome to Royal Albatross Exports - Where Quality Meets Divinity
                        </p>
                        <div class="welcome-divider">
                            <span>ॐ नमः शिवाय</span>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg welcome-btn" data-bs-dismiss="modal">
                            <i class="fas fa-hands-praying me-2"></i>Continue with Blessings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-modal-content {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    background: linear-gradient(135deg, #fff9e6 0%, #ffffff 100%);
}

.welcome-modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 10;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    width: 35px;
    height: 35px;
    opacity: 0.8;
    transition: all 0.3s ease;
}

.welcome-modal-close:hover {
    opacity: 1;
    transform: rotate(90deg);
    background: white;
}

.welcome-modal-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.welcome-image-container {
    position: relative;
    width: 100%;
    max-height: 400px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #ff9933 0%, #ffffff 50%, #138808 100%);
    padding: 30px;
}

.welcome-image {
    max-width: 100%;
    max-height: 350px;
    object-fit: contain;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    animation: divineGlow 3s ease-in-out infinite;
    position: relative;
    z-index: 2;
}

.divine-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255, 215, 0, 0.4) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
    z-index: 1;
}

@keyframes divineGlow {
    0%, 100% {
        filter: brightness(1) drop-shadow(0 0 10px rgba(255, 215, 0, 0.5));
    }
    50% {
        filter: brightness(1.1) drop-shadow(0 0 20px rgba(255, 215, 0, 0.8));
    }
}

@keyframes pulse {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.5;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 0.8;
    }
}

.welcome-content {
    padding: 40px 30px;
    text-align: center;
}

.welcome-icon {
    font-size: 3rem;
    color: #ff9933;
    margin-bottom: 20px;
    animation: rotate 10s linear infinite;
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #ff9933 0%, #138808 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-message {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 15px;
    line-height: 1.6;
    font-weight: 500;
}

.welcome-submessage {
    font-size: 0.95rem;
    color: #777;
    margin-bottom: 25px;
    font-style: italic;
}

.welcome-divider {
    margin: 25px 0;
    position: relative;
}

.welcome-divider::before,
.welcome-divider::after {
    content: '';
    position: absolute;
    top: 50%;
    width: 30%;
    height: 2px;
    background: linear-gradient(to right, transparent, #ff9933, transparent);
}

.welcome-divider::before {
    left: 0;
}

.welcome-divider::after {
    right: 0;
}

.welcome-divider span {
    font-size: 1.3rem;
    color: #ff9933;
    font-weight: 600;
    padding: 0 20px;
    background: linear-gradient(135deg, #fff9e6 0%, #ffffff 100%);
}

.welcome-btn {
    background: linear-gradient(135deg, #ff9933 0%, #ff6600 100%);
    border: none;
    padding: 15px 40px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 50px;
    box-shadow: 0 5px 20px rgba(255, 153, 51, 0.4);
    transition: all 0.3s ease;
}

.welcome-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 153, 51, 0.6);
    background: linear-gradient(135deg, #ff6600 0%, #ff9933 100%);
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-image-container {
        max-height: 300px;
        padding: 20px;
    }
    
    .welcome-image {
        max-height: 250px;
    }
    
    .welcome-content {
        padding: 30px 20px;
    }
    
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .welcome-message {
        font-size: 1rem;
    }
    
    .welcome-btn {
        padding: 12px 30px;
        font-size: 1rem;
    }
}

/* Modal entrance animation */
.modal.fade .modal-dialog {
    transition: transform 0.5s ease-out;
}

.modal.show .modal-dialog {
    animation: modalSlideIn 0.5s ease-out;
}

@keyframes modalSlideIn {
    from {
        transform: scale(0.7) translateY(-50px);
        opacity: 0;
    }
    to {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
}
</style>

<script>
// Welcome Modal Logic
(function() {
    'use strict';
    
    function initWelcomeModal() {
        const welcomeModal = document.getElementById('welcomeModal');
        
        if (!welcomeModal) {
            console.log('Welcome modal element not found');
            return;
        }
        
        // Check if Bootstrap is loaded
        if (typeof bootstrap === 'undefined') {
            console.log('Bootstrap not loaded yet, waiting...');
            setTimeout(initWelcomeModal, 100);
            return;
        }
        
        console.log('Initializing welcome modal...');
        
        // Check if modal has been shown in the last 2 days
        const lastShown = localStorage.getItem('welcomeModalLastShown');
        const twoDaysInMs = 2 * 24 * 60 * 60 * 1000; // 2 days in milliseconds
        const now = new Date().getTime();
        
        let shouldShow = false;
        
        if (!lastShown) {
            // Never shown before
            console.log('Modal never shown before - will display');
            shouldShow = true;
        } else {
            const lastShownTime = parseInt(lastShown);
            const timeSinceLastShown = now - lastShownTime;
            const daysAgo = timeSinceLastShown / (24 * 60 * 60 * 1000);
            console.log(`Modal last shown ${daysAgo.toFixed(2)} days ago`);
            
            if (timeSinceLastShown > twoDaysInMs) {
                // More than 2 days have passed
                console.log('More than 2 days passed - will display');
                shouldShow = true;
            } else {
                console.log('Less than 2 days - will not display');
            }
        }
        
        if (shouldShow) {
            // Show the modal after a short delay for better UX
            setTimeout(function() {
                try {
                    const modal = new bootstrap.Modal(welcomeModal, {
                        backdrop: 'static',
                        keyboard: false
                    });
                    modal.show();
                    console.log('Welcome modal displayed successfully');
                    
                    // Store the current timestamp
                    localStorage.setItem('welcomeModalLastShown', now.toString());
                } catch (error) {
                    console.error('Error showing welcome modal:', error);
                }
            }, 1500); // 1.5 second delay
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWelcomeModal);
    } else {
        // DOM already loaded
        initWelcomeModal();
    }
})();
</script>

