import './bootstrap';

// ======= LoveLab Interactive JavaScript =======

document.addEventListener('DOMContentLoaded', function() {
    initializeNavigation();
    initializeBookingModal();
    initializeAnimations();
    initializeSuccessToast();
    initializeSmoothScrolling();
});

// ===== Navigation System =====
function initializeNavigation() {
    const nav = document.querySelector('nav');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            nav?.classList.add('scrolled');
        } else {
            nav?.classList.remove('scrolled');
        }
    });

    // Mobile menu toggle
    mobileMenuBtn?.addEventListener('click', () => {
        mobileMenu?.classList.toggle('open');
        
        // Animate hamburger icon
        const icon = mobileMenuBtn.querySelector('i');
        if (mobileMenu?.classList.contains('open')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Close mobile menu when clicking on links
    document.querySelectorAll('.mobile-nav-link').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu?.classList.remove('open');
            const icon = mobileMenuBtn?.querySelector('i');
            icon?.classList.remove('fa-times');
            icon?.classList.add('fa-bars');
        });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!nav?.contains(e.target) && mobileMenu?.classList.contains('open')) {
            mobileMenu.classList.remove('open');
            const icon = mobileMenuBtn?.querySelector('i');
            icon?.classList.remove('fa-times');
            icon?.classList.add('fa-bars');
        }
    });
}

function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu?.classList.toggle('open');
}

// ===== Booking Modal System =====
function initializeBookingModal() {
    window.selectPlan = function(planType, groupSize, price) {
        openBookingModal(planType, groupSize, price);
    };

    window.closeModal = function() {
        const modal = document.getElementById('booking-modal');
        const content = document.getElementById('modal-content');
        
        content.style.transform = 'scale(0.9)';
        content.style.opacity = '0';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            content.style.transform = 'scale(1)';
            content.style.opacity = '1';
        }, 300);
    };
}

function openBookingModal(planType, groupSize, price) {
    const modal = document.getElementById('booking-modal');
    const content = document.getElementById('modal-content');
    
    // Show modal
    modal.classList.remove('hidden');
    
    // Animate modal entrance
    setTimeout(() => {
        content.style.transform = 'scale(1)';
        content.style.opacity = '1';
    }, 10);
    
    // Populate modal content
    content.innerHTML = generateModalContent(planType, groupSize, price);
    
    // Initialize form handling
    initializeBookingForm();
}

function generateModalContent(planType, groupSize, price) {
    const planEmojis = {
        'IP': '🌟',
        'VIP': '👑',
        'VVIP': '💎'
    };

    const planColors = {
        'IP': 'pink',
        'VIP': 'purple',
        'VVIP': 'amber'
    };

    const color = planColors[planType];

    return `
        <div class="text-center mb-8">
            <div class="text-5xl mb-4">${planEmojis[planType]}</div>
            <h2 class="text-3xl font-bold text-white mb-2">${planType} Experience</h2>
            <p class="text-white/60">${groupSize} ${groupSize === 1 ? 'ticket' : 'tickets'} • KSH ${price.toLocaleString()}</p>
        </div>

        <form id="booking-form" method="POST" action="/submit-booking" class="space-y-6">
            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
            <input type="hidden" name="plan_type" value="${planType}">
            <input type="hidden" name="group_size" value="${groupSize}">

            <!-- Team Lead Information -->
            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                    <i class="fas fa-user-crown mr-3 text-${color}-400"></i>
                    Team Lead Information
                </h3>
                
                <div>
                    <label class="block text-white/80 font-medium mb-2">
                        <i class="fas fa-user mr-2"></i>Full Name
                    </label>
                    <input type="text" name="team_lead_name" required 
                           class="form-input" placeholder="Enter your full name">
                </div>

                <div>
                    <label class="block text-white/80 font-medium mb-2">
                        <i class="fas fa-envelope mr-2"></i>Email Address
                    </label>
                    <input type="email" name="team_lead_email" required 
                           class="form-input" placeholder="your@email.com">
                </div>

                <div>
                    <label class="block text-white/80 font-medium mb-2">
                        <i class="fas fa-phone mr-2"></i>Phone Number
                    </label>
                    <input type="tel" name="team_lead_phone" required 
                           class="form-input" placeholder="+254 7XX XXX XXX">
                </div>
            </div>

            ${groupSize > 1 ? generateMembersSection(groupSize - 1, color) : ''}

            <!-- Action Buttons -->
            <div class="flex space-x-4 pt-6">
                <button type="button" onclick="closeModal()" 
                        class="flex-1 bg-white/10 hover:bg-white/20 text-white border border-white/20 hover:border-white/40 font-semibold py-3 px-6 rounded-xl transition-all duration-300">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-${color}-500 to-${color === 'amber' ? 'yellow' : color}-600 hover:from-${color}-600 hover:to-${color === 'amber' ? 'yellow' : color}-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-credit-card mr-2"></i>
                    Proceed to Payment
                </button>
            </div>
        </form>
    `;
}

function generateMembersSection(memberCount, color) {
    let membersHtml = `
        <div class="space-y-4">
            <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-users mr-3 text-${color}-400"></i>
                Team Members (${memberCount})
            </h3>
            <div id="members-container" class="space-y-4">
    `;

    for (let i = 0; i < memberCount; i++) {
        membersHtml += `
            <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                <h4 class="text-white/80 font-medium mb-3">Member ${i + 1}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-white/60 text-sm mb-1">Name</label>
                        <input type="text" name="members[${i}][name]" required 
                               class="form-input" placeholder="Member name">
                    </div>
                    <div>
                        <label class="block text-white/60 text-sm mb-1">Email</label>
                        <input type="email" name="members[${i}][email]" required 
                               class="form-input" placeholder="member@email.com">
                    </div>
                </div>
            </div>
        `;
    }

    membersHtml += `
            </div>
        </div>
    `;

    return membersHtml;
}

function initializeBookingForm() {
    const form = document.getElementById('booking-form');
    
    form?.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        
        // Add loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        submitBtn.disabled = true;
        
        // Let the form submit naturally
    });
}

// ===== Animation System =====
function initializeAnimations() {
    // Intersection Observer for scroll animations
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

    // Observe pricing cards
    document.querySelectorAll('.pricing-card').forEach(card => {
        observer.observe(card);
    });

    // Add hover effects to pricing options
    document.querySelectorAll('.pricing-option').forEach(option => {
        option.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        option.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// ===== Success Toast System =====
function initializeSuccessToast() {
    const toast = document.getElementById('success-toast');
    
    if (toast) {
        // Show toast
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 500);
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
        }, 5500);
    }
}

window.hideToast = function() {
    const toast = document.getElementById('success-toast');
    if (toast) {
        toast.style.transform = 'translateX(100%)';
    }
};

// ===== Smooth Scrolling =====
function initializeSmoothScrolling() {
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

// ===== Utility Functions =====

// Parallax effect for floating elements
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.animate-float, .animate-float-delayed');
    
    parallaxElements.forEach(element => {
        const speed = 0.5;
        element.style.transform = `translateY(${scrolled * speed}px)`;
    });
});

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

// Add resize handler with debounce
window.addEventListener('resize', debounce(() => {
    // Handle window resize events
    console.log('Window resized');
}, 250));

// Preloader (if needed)
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
});

// Export functions for global use
window.LoveLab = {
    selectPlan: window.selectPlan,
    closeModal: window.closeModal,
    hideToast: window.hideToast
};
let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('DOMContentLoaded', function() {
    // Handle pricing category button clicks
    document.querySelectorAll('.pricing-category').forEach(button => {
        button.addEventListener('click', function() {
            const planType = this.closest('.plan').querySelector('h3').textContent;
            const categoryText = this.querySelector('h4').textContent;
            const priceText = this.querySelector('p').textContent; // Get the price text
            
            let groupSize;
            if (categoryText.toLowerCase().includes('single')) {
                groupSize = 1;
            } else if (categoryText.toLowerCase().includes('couple')) {
                groupSize = 2;
            } else {
                const match = categoryText.match(/\d+/);
                groupSize = match ? parseInt(match[0]) : 1;
            }
            
            showBookingForm(planType, groupSize, priceText, );
        });
    });
});

function showBookingForm(planType, groupSize, priceText) {
    let formHTML = `
    <div class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Booking for ${planType} (${groupSize} ${groupSize > 1 ? 'people' : 'person'})</h3>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="price-info" style="text-align: center; margin-bottom: 20px; padding: 10px; background-color: #f8f8f8; border-radius: 4px;">
                    <strong>Package Price:</strong> ${priceText}
                </div>
                <form id="bookingForm" method="POST" action="/submit-booking">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="plan_type" value="${planType}">
                    <input type="hidden" name="group_size" value="${groupSize}">
                    <input type="hidden" name="price" value="${priceText}">
                    <div class="form-group">
                        <label>Team Lead Details:</label>
                        <input type="email" name="team_lead_email" placeholder="Team Lead Email" required>
                        <input type="text" name="team_lead_name" placeholder="Team Lead Name" required>
                        <input type="tel" name="team_lead_phone" placeholder="Team Lead Phone" required>
                    </div>`;

    if (groupSize > 1) {
        formHTML += `<div class="members-container">`;
        for (let i = 1; i < groupSize; i++) {
            formHTML += `
                <div class="form-group member">
                    <label>Member ${i} Details:</label>
                    <input type="text" name="members[${i}][name]" placeholder="Member ${i} Name" required>
                    <input type="email" name="members[${i}][email]" placeholder="Member ${i} Email" required>
                </div>`;
        }
        formHTML += `</div>`;
    }

    formHTML += `
                <button type="submit">Complete Booking</button>
            </form>
        </div>
    </div>
    </div>`;

    // Insert the modal HTML into the DOM
    document.body.insertAdjacentHTML('beforeend', formHTML);

    // Add event listener to close the modal
    document.querySelector('.close').addEventListener('click', () => {
        document.querySelector('.modal').remove();
    });
}
// Add form validation for M-Pesa code
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const mpesaCode = this.querySelector('[name="mpesa_confirmation_code"]');
        if (mpesaCode && !/^[A-Z0-9]{10}$/.test(mpesaCode.value)) {
            e.preventDefault();
            alert('Please enter a valid 10-character M-Pesa confirmation code');
            mpesaCode.focus();
        }
    });
});