<!-- Navigation -->
<nav class="navbar" role="navigation" aria-label="Main navigation">
    <div class="nav-container">
        <div class="nav-brand">
            <h1 style="display:flex; align-items:center; gap:10px;">
                <img src="{{ asset('images/logo.png') }}" alt="Tiko Iko On Logo - Kenya's Premier Entertainment Experience" style="height:50px; margin-right:0;">
                <a href="{{ url('/') }}" style="text-decoration: none; color: inherit;">
                    <span>Tiko Iko On</span>
                </a>
            </h1>
            <span class="brand-tagline">Where Vibes Come Alive</span>
        </div>
        <div class="nav-links">
            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/#events') }}" class="nav-link">Events</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            
            <!-- Contact Dropdown -->
            <div class="nav-contact-dropdown" id="contactDropdown">
                <a href="#" class="nav-link contact-toggle" id="contactToggle">Contact <i class="fas fa-chevron-down"></i></a>
                <div class="contact-dropdown-content" id="contactDropdownContent">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:+254745825239" style="color: inherit; text-decoration: none;">+254 745 825 239</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:tikoikoon@gmail.com" style="color: inherit; text-decoration: none;">tikoikoon@gmail.com</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-toggle" aria-label="Toggle navigation menu" role="button" tabindex="0">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu" role="navigation" aria-label="Mobile navigation menu">
        <a href="{{ url('/') }}" class="mobile-nav-link" role="menuitem">
            <i class="fas fa-home" aria-hidden="true"></i>
            <span>Home</span>
        </a>
        <a href="{{ url('/#events') }}" class="mobile-nav-link" role="menuitem">
            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
            <span>Events</span>
        </a>
        <a href="{{ route('about') }}" class="mobile-nav-link" role="menuitem">
            <i class="fas fa-info-circle" aria-hidden="true"></i>
            <span>About</span>
        </a>
        
        <!-- Contact Section in Mobile -->
        <div class="mobile-contact-section" style="padding: 12px 24px; border-top: 1px solid rgba(255,255,255,0.08);">
            <div style="color: #ff2e63; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">
                <i class="fas fa-envelope" aria-hidden="true"></i> Contact Us
            </div>
            <a href="tel:+254745825239" class="mobile-contact-item" style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.9rem; margin-bottom: 6px;">
                <i class="fas fa-phone" style="color: #08d9d6; font-size: 0.8rem;"></i>
                <span>+254 745 825 239</span>
            </a>
            <a href="mailto:tikoikoon@gmail.com" class="mobile-contact-item" style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.9rem;">
                <i class="fas fa-envelope" style="color: #08d9d6; font-size: 0.8rem;"></i>
                <span>tikoikoon@gmail.com</span>
            </a>
        </div>
    </div>
</nav>

<!-- Success Message -->
@if (session('success'))
    <div class="success-notification" style="position: fixed; top: 100px; right: 20px; z-index: 9999; background: linear-gradient(135deg, #00ff87, #60efff); padding: 20px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); animation: slideIn 0.5s ease;">
        <div class="success-content" style="display: flex; align-items: center; gap: 15px;">
            <div class="success-icon" style="font-size: 2rem;">🎉</div>
            <div class="success-text">
                <h3 style="margin: 0; color: #000; font-weight: bold;">Booking Confirmed!</h3>
                <p style="margin: 5px 0 0; color: #333;">{{ session('success') }}</p>
            </div>
            <button class="success-close" onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #000;">&times;</button>
        </div>
    </div>
@endif

<script>
// Enhanced mobile menu toggle with better touch support
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.querySelector('.nav-toggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    
    if (navToggle && mobileMenu) {
        
        // Toggle menu function
        function toggleMenu() {
            const isOpen = mobileMenu.classList.contains('open');
            
            if (isOpen) {
                // Close menu
                mobileMenu.classList.remove('open');
                navToggle.classList.remove('active');
                navToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = ''; // Re-enable scrolling
            } else {
                // Open menu
                mobileMenu.classList.add('open');
                navToggle.classList.add('active');
                navToggle.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
        }
        
        // Handle click and touch events on toggle button
        navToggle.addEventListener('click', toggleMenu);
        navToggle.addEventListener('touchstart', function(e) {
            e.preventDefault(); // Prevent double-tap zoom
            toggleMenu();
        });
        
        // Handle keyboard navigation
        navToggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleMenu();
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (mobileMenu.classList.contains('open')) {
                if (!mobileMenu.contains(e.target) && !navToggle.contains(e.target)) {
                    mobileMenu.classList.remove('open');
                    navToggle.classList.remove('active');
                    navToggle.setAttribute('aria-expanded', 'false');
                    document.body.style.overflow = '';
                }
            }
        });
        
        // Close menu when clicking on navigation links
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.remove('open');
                navToggle.classList.remove('active');
                navToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });
        
        // Handle screen resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                mobileMenu.classList.remove('open');
                navToggle.classList.remove('active');
                navToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
        });
        
        // Set initial ARIA attributes
        navToggle.setAttribute('aria-expanded', 'false');
        navToggle.setAttribute('aria-controls', 'mobileMenu');
        mobileMenu.setAttribute('aria-hidden', 'true');
        
        // Update ARIA attributes when menu state changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    const isOpen = mobileMenu.classList.contains('open');
                    mobileMenu.setAttribute('aria-hidden', !isOpen);
                }
            });
        });
        observer.observe(mobileMenu, { attributes: true });
    }

    // Contact dropdown functionality
    const contactToggle = document.getElementById('contactToggle');
    const contactDropdown = document.getElementById('contactDropdownContent');
    
    if (contactToggle && contactDropdown) {
        // Toggle dropdown on click
        contactToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isOpen = contactDropdown.classList.contains('show');
            
            // Close any other open dropdowns first
            document.querySelectorAll('.contact-dropdown-content.show').forEach(dropdown => {
                if (dropdown !== contactDropdown) {
                    dropdown.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            if (isOpen) {
                contactDropdown.classList.remove('show');
                contactToggle.querySelector('.fa-chevron-down').style.transform = 'rotate(0deg)';
            } else {
                contactDropdown.classList.add('show');
                contactToggle.querySelector('.fa-chevron-down').style.transform = 'rotate(180deg)';
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!contactToggle.contains(e.target) && !contactDropdown.contains(e.target)) {
                contactDropdown.classList.remove('show');
                contactToggle.querySelector('.fa-chevron-down').style.transform = 'rotate(0deg)';
            }
        });
        
        // Handle touch events for mobile
        contactToggle.addEventListener('touchstart', function(e) {
            e.preventDefault();
            contactToggle.click();
        });
    }
});

// Auto-hide success message
setTimeout(() => {
    const notification = document.querySelector('.success-notification');
    if (notification) {
        notification.style.animation = 'slideOut 0.9s ease';
        setTimeout(() => notification.remove(), 500);
    }
}, 5000);
</script>
