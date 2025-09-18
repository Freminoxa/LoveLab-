import './bootstrap';

/**
 * Tiko Iko On - Interactive JavaScript
 * Main application controller for the party booking system
 */

class TikoIkoApp {
    constructor() {
        this.pricingData = {
            IP: { 1: 500, 2: 800, 6: 1500, 10: 2500 },
            VIP: { 1: 1000, 2: 1800, 6: 4500, 10: 7500 },
            VVIP: { 1: 2500, 2: 4800, 6: 13500, 10: 22500 }
        };
        
        this.planEmojis = {
            'IP': '🌟',
            'VIP': '👑',
            'VVIP': '💎'
        };
        
        this.planColors = {
            'IP': 'pink',
            'VIP': 'purple',
            'VVIP': 'amber'
        };
        
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.activeModal = null;
        
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initializeApp());
        } else {
            this.initializeApp();
        }
    }

    initializeApp() {
        this.initializeNavigation();
        this.initializePricingSystem();
        this.initializeAnimations();
        this.initializeScrollEffects();
        this.initializeSmoothScrolling();
        this.handleSuccessNotifications();
        this.bindGlobalEvents();
        
        console.log('🎆 Tiko Iko On - Ready to party! 🎉');
    }

    // ========================================
    // Navigation System
    // ========================================
    initializeNavigation() {
        const nav = document.querySelector('nav, .navbar');
        const navToggle = document.querySelector('.nav-toggle');
        const mobileMenu = document.querySelector('.mobile-menu, #mobile-menu');
        const navLinks = document.querySelector('.nav-links');

        // Navbar scroll effect
        if (nav) {
            window.addEventListener('scroll', this.debounce(() => {
                if (window.scrollY > 50) {
                    nav.classList.add('scrolled');
                } else {
                    nav.classList.remove('scrolled');
                }
            }, 10));
        }

        // Mobile menu toggle
        if (navToggle && (mobileMenu || navLinks)) {
            navToggle.addEventListener('click', () => {
                this.toggleMobileMenu(mobileMenu, navLinks, navToggle);
            });
        }

        // Close mobile menu on link clicks
        document.querySelectorAll('.mobile-nav-link, .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                this.closeMobileMenu(mobileMenu, navLinks, navToggle);
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            const navContainer = nav || navToggle?.closest('nav');
            if (navContainer && !navContainer.contains(e.target)) {
                this.closeMobileMenu(mobileMenu, navLinks, navToggle);
            }
        });
    }

    toggleMobileMenu(mobileMenu, navLinks, navToggle) {
        const menu = mobileMenu || navLinks;
        if (!menu) return;

        menu.classList.toggle('open');
        menu.classList.toggle('active');
        navToggle?.classList.toggle('active');

        // Animate hamburger icon
        const icon = navToggle?.querySelector('i');
        if (icon) {
            if (menu.classList.contains('open') || menu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
    }

    closeMobileMenu(mobileMenu, navLinks, navToggle) {
        const menu = mobileMenu || navLinks;
        if (!menu) return;

        menu.classList.remove('open', 'active');
        navToggle?.classList.remove('active');

        const icon = navToggle?.querySelector('i');
        if (icon) {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    }

    // ========================================
    // Pricing & Booking System
    // ========================================
    initializePricingSystem() {
        // Handle pricing category clicks (new approach)
        document.querySelectorAll('.pricing-category').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.handlePricingCategoryClick(button);
            });
        });

        // Handle legacy pricing option clicks
        document.querySelectorAll('.pricing-option').forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault();
                this.handlePricingOptionClick(option);
            });
        });

        // Global function exposure for backwards compatibility
        window.selectPlan = (planType, groupSize, price) => {
            this.openBookingModal(planType, groupSize, price);
        };
    }

    handlePricingCategoryClick(button) {
        const plan = button.closest('.plan');
        const planType = plan?.querySelector('h3')?.textContent?.trim();
        const categoryText = button.querySelector('h4')?.textContent || '';
        const priceText = button.querySelector('p')?.textContent || '';
        
        if (!planType) {
            console.error('Could not determine plan type');
            return;
        }

        const groupSize = this.extractGroupSize(categoryText);
        const price = this.extractPrice(priceText) || this.pricingData[planType]?.[groupSize] || 0;
        
        this.openBookingModal(planType, groupSize, price);
    }

    handlePricingOptionClick(option) {
        const card = option.closest('.pricing-card');
        const plan = card?.dataset.plan;
        const size = parseInt(option.dataset.size);
        const price = parseInt(option.dataset.price);
        
        if (plan && size && price) {
            this.openBookingModal(plan, size, price);
        }
    }

    extractGroupSize(categoryText) {
        const text = categoryText.toLowerCase();
        if (text.includes('single')) return 1;
        if (text.includes('couple')) return 2;
        
        const match = categoryText.match(/\d+/);
        return match ? parseInt(match[0]) : 1;
    }

    extractPrice(priceText) {
        const match = priceText.match(/[\d,]+/);
        return match ? parseInt(match[0].replace(/,/g, '')) : null;
    }

    // ========================================
    // Modal System
    // ========================================
    openBookingModal(planType, groupSize, price) {
        this.closeActiveModal();

        const modal = this.createModal(planType, groupSize, price);
        document.body.appendChild(modal);
        this.activeModal = modal;

        // Animate modal entrance
        requestAnimationFrame(() => {
            modal.classList.add('active');
            const content = modal.querySelector('.modal-content');
            if (content) {
                content.style.transform = 'scale(1)';
                content.style.opacity = '1';
            }
        });

        this.initializeModalEvents(modal);
    }

    createModal(planType, groupSize, price) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = this.generateModalContent(planType, groupSize, price);
        return modal;
    }

    generateModalContent(planType, groupSize, price) {
        const color = this.planColors[planType];
        const emoji = this.planEmojis[planType];
        
        return `
            <div class="modal-content">
                <div class="modal-header">
                    <div class="text-center">
                        <div class="text-4xl mb-2">${emoji}</div>
                        <h3>Booking for ${planType} Experience</h3>
                        <p class="text-sm opacity-75">${groupSize} ${groupSize > 1 ? 'people' : 'person'} • KSH ${price.toLocaleString()}</p>
                    </div>
                    <span class="close" onclick="tikoIko.closeModal()">&times;</span>
                </div>
                
                <div class="modal-body">
                    <form id="bookingForm" method="POST" action="/submit-booking">
                        <input type="hidden" name="_token" value="${this.csrfToken}">
                        <input type="hidden" name="plan_type" value="${planType}">
                        <input type="hidden" name="group_size" value="${groupSize}">
                        <input type="hidden" name="price" value="${price}">
                        
                        <!-- Team Lead Information -->
                        <div class="form-section">
                            <h4><i class="fas fa-user-crown"></i> Team Lead Information</h4>
                            
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" name="team_lead_name" required placeholder="Enter your full name">
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" name="team_lead_email" required placeholder="your@email.com">
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Phone Number</label>
                                <input type="tel" name="team_lead_phone" required placeholder="+254 7XX XXX XXX">
                            </div>
                        </div>

                        ${groupSize > 1 ? this.generateMembersSection(groupSize - 1) : ''}

                        <div class="form-actions">
                            <button type="button" class="btn-secondary" onclick="tikoIko.closeModal()">
                                Cancel
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-credit-card"></i>
                                Proceed to Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        `;
    }

    generateMembersSection(memberCount) {
        let html = `
            <div class="form-section">
                <h4><i class="fas fa-users"></i> Team Members (${memberCount})</h4>
                <div class="members-container">
        `;

        for (let i = 0; i < memberCount; i++) {
            html += `
                <div class="member-group">
                    <h5>Member ${i + 1}</h5>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="members[${i}][name]" required placeholder="Member name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="members[${i}][email]" required placeholder="member@email.com">
                        </div>
                    </div>
                </div>
            `;
        }

        html += `
                </div>
            </div>
        `;

        return html;
    }

    initializeModalEvents(modal) {
        const form = modal.querySelector('#bookingForm');
        
        if (form) {
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    submitBtn.disabled = true;
                }
                
                // Validate M-Pesa code if present
                const mpesaCode = form.querySelector('[name="mpesa_confirmation_code"]');
                if (mpesaCode && !/^[A-Z0-9]{10}$/.test(mpesaCode.value)) {
                    e.preventDefault();
                    alert('Please enter a valid 10-character M-Pesa confirmation code');
                    mpesaCode.focus();
                    
                    // Reset button
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-credit-card"></i> Proceed to Payment';
                        submitBtn.disabled = false;
                    }
                    return false;
                }
            });
        }

        // Close modal on outside click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                this.closeModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.activeModal) {
                this.closeModal();
            }
        });
    }

    closeModal() {
        if (this.activeModal) {
            const content = this.activeModal.querySelector('.modal-content');
            if (content) {
                content.style.transform = 'scale(0.9)';
                content.style.opacity = '0';
            }

            setTimeout(() => {
                if (this.activeModal) {
                    this.activeModal.remove();
                    this.activeModal = null;
                }
            }, 300);
        }
    }

    closeActiveModal() {
        if (this.activeModal) {
            this.activeModal.remove();
            this.activeModal = null;
        }
    }

    // ========================================
    // Animation System
    // ========================================
    initializeAnimations() {
        this.initializeScrollAnimations();
        this.initializeHoverEffects();
    }

    initializeScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slide-up');
                }
            });
        }, observerOptions);

        // Observe elements for scroll animations
        document.querySelectorAll('.pricing-card, .plan, .pricing-category').forEach(element => {
            observer.observe(element);
        });
    }

    initializeHoverEffects() {
        // Pricing options hover effects
        document.querySelectorAll('.pricing-option, .pricing-category').forEach(option => {
            option.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            option.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    // ========================================
    // Scroll Effects
    // ========================================
    initializeScrollEffects() {
        // Parallax effect for floating elements
        window.addEventListener('scroll', this.debounce(() => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.animate-float, .animate-float-delayed');
            
            parallaxElements.forEach(element => {
                const speed = 0.5;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        }, 16)); // ~60fps
    }

    initializeSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    // ========================================
    // Success Notifications
    // ========================================
    handleSuccessNotifications() {
        const successNotification = document.querySelector('.success-notification');
        const successToast = document.getElementById('success-toast');
        
        if (successNotification) {
            this.showSuccessNotification(successNotification);
        }
        
        if (successToast) {
            this.showSuccessToast(successToast);
        }
    }

    showSuccessNotification(notification) {
        setTimeout(() => {
            notification.style.display = 'block';
            notification.classList.add('animate-slide-up');
        }, 500);
        
        setTimeout(() => {
            notification.style.display = 'none';
        }, 5000);

        // Close button handler
        const closeBtn = notification.querySelector('.success-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                notification.style.display = 'none';
            });
        }
    }

    showSuccessToast(toast) {
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 500);
        
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
        }, 5500);

        // Global function for hiding toast
        window.hideToast = () => {
            toast.style.transform = 'translateX(100%)';
        };
    }

    // ========================================
    // Global Event Handlers
    // ========================================
    bindGlobalEvents() {
        // Window load event
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });

        // Resize handler
        window.addEventListener('resize', this.debounce(() => {
            // Handle responsive adjustments
            this.handleWindowResize();
        }, 250));

        // Form validation for all forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form, e)) {
                    e.preventDefault();
                }
            });
        });
    }

    handleWindowResize() {
        // Close mobile menu on desktop
        if (window.innerWidth > 768) {
            this.closeMobileMenu(
                document.querySelector('.mobile-menu'),
                document.querySelector('.nav-links'),
                document.querySelector('.nav-toggle')
            );
        }
    }

    validateForm(form, event) {
        const mpesaCode = form.querySelector('[name="mpesa_confirmation_code"]');
        
        if (mpesaCode && mpesaCode.value && !/^[A-Z0-9]{10}$/.test(mpesaCode.value)) {
            alert('Please enter a valid 10-character M-Pesa confirmation code');
            mpesaCode.focus();
            return false;
        }
        
        return true;
    }

    // ========================================
    // Utility Functions
    // ========================================
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func.apply(this, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // ========================================
    // Public API
    // ========================================
    getAPI() {
        return {
            selectPlan: (planType, groupSize, price) => this.openBookingModal(planType, groupSize, price),
            closeModal: () => this.closeModal(),
            hideToast: () => window.hideToast?.(),
            toggleMobileMenu: () => this.toggleMobileMenu(
                document.querySelector('.mobile-menu'),
                document.querySelector('.nav-links'),
                document.querySelector('.nav-toggle')
            )
        };
    }
}

// Initialize the application
const tikoIko = new TikoIkoApp();

// Expose global API for backwards compatibility
window.TikoIko = tikoIko.getAPI();
window.tikoIko = tikoIko;

// Legacy global functions
window.selectPlan = window.TikoIko.selectPlan;
window.closeModal = window.TikoIko.closeModal;
window.hideToast = window.TikoIko.hideToast;
window.toggleMobileMenu = window.TikoIko.toggleMobileMenu;

export default tikoIko;