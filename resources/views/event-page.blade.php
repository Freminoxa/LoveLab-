@extends('layout')

@section('title', $event->name . ' - Tiko Iko On')

@section('head')
    <!-- Event-specific SEO meta tags -->
    <meta name="description" content="Join {{ $event->name }} at {{ $event->venue ?? $event->location }} on {{ $event->date->format('F j, Y') }}. Book your tickets now for an unforgettable experience!">
    <meta property="og:title" content="{{ $event->name }} - Tiko Iko On">
    <meta property="og:description" content="{{ Str::limit($event->description, 150) }}">
    @if($event->poster)
    <meta property="og:image" content="{{ asset('storage/' . $event->poster) }}">
    @endif
@endsection

@section('content')
<!-- Event Hero Section with Animated Background -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden" style="padding-top: 100px;">
    <!-- Dynamic Background -->
    <div class="absolute inset-0 z-0">
        @if($event->poster)
            <img src="{{ asset('storage/' . $event->poster) }}" 
                 alt="{{ $event->name }} event poster" 
                 class="w-full h-full object-cover transform scale-110 transition-transform duration-1000"
                 style="filter: blur(2px);">
        @endif
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/80 via-pink-800/80 to-indigo-900/80"></div>
        <div class="absolute inset-0 bg-black/40"></div>
        
        <!-- Floating Particles Animation -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="particle" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
            <div class="particle" style="top: 60%; left: 80%; animation-delay: 2s;"></div>
            <div class="particle" style="top: 30%; left: 60%; animation-delay: 4s;"></div>
            <div class="particle" style="top: 80%; left: 20%; animation-delay: 6s;"></div>
            <div class="particle" style="top: 40%; left: 90%; animation-delay: 8s;"></div>
        </div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 text-center text-white px-6 max-w-5xl mx-auto">
        <!-- Event Badge -->
        <div class="inline-flex items-center bg-gradient-to-r from-pink-500/20 to-purple-600/20 backdrop-blur-md border border-white/20 rounded-full px-6 py-2 mb-6 animate-pulse">
            <i class="fas fa-star text-yellow-400 mr-2"></i>
            <span class="text-sm font-medium">Premium Event</span>
        </div>
        
        <!-- Event Title -->
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-8 leading-tight">
            <span class="bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent animate-gradient-x">
                {{ $event->name }}
            </span>
        </h1>
        
        <!-- Event Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 max-w-4xl mx-auto">
            <!-- Date & Time -->
            <div class="event-detail-card group">
                <div class="event-detail-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-1">Date & Time</h3>
                    <p class="text-gray-300 text-sm">{{ $event->date->format('l, F j, Y') }}</p>
                    <p class="text-pink-400 font-medium">{{ $event->date->format('g:i A') }}</p>
                </div>
            </div>
            
            <!-- Location -->
            <div class="event-detail-card group">
                <div class="event-detail-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-1">Venue</h3>
                    <p class="text-gray-300 text-sm">{{ $event->venue ?? $event->location }}</p>
                    <p class="text-indigo-400 font-medium">Premium Location</p>
                </div>
            </div>
            
            <!-- Till Number -->
            <div class="event-detail-card group">
                <div class="event-detail-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-1">Payment</h3>
                    @if($event->till_number)
                        <p class="text-gray-300 text-sm">Till Number</p>
                        <p class="text-green-400 font-medium">{{ $event->till_number }}</p>
                    @else
                        <p class="text-gray-300 text-sm">Multiple Options</p>
                        <p class="text-green-400 font-medium">Available</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Event Description -->
        @if($event->description)
        <div class="max-w-3xl mx-auto mb-8">
            <p class="text-lg md:text-xl text-gray-200 leading-relaxed">
                {{ $event->description }}
            </p>
        </div>
        @endif
        
        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button onclick="scrollToPackages()" 
                    class="cta-button-primary group">
                <i class="fas fa-ticket-alt mr-3 group-hover:rotate-12 transition-transform duration-300"></i>
                Get Your Tickets
                <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10"></div>
            </button>
            
            <button onclick="shareEvent()" 
                    class="cta-button-secondary group">
                <i class="fas fa-share-alt mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                Share Event
            </button>
        </div>
        
        <!-- Countdown Timer -->
        <div class="mt-12">
            <h3 class="text-xl font-semibold mb-4 text-gray-300">Event Starts In:</h3>
            <div id="countdown" class="flex justify-center space-x-4">
                <!-- Countdown will be populated by JavaScript -->
            </div>
        </div>
    </div>
</section>
    
<!-- Ticket Packages Section -->
<section class="py-20 px-6 relative" id="packages-section">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-purple-900 via-pink-800 to-indigo-900"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                <span class="bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">
                    Choose Your Experience
                </span>
            </h2>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Select the perfect package for an unforgettable night. Each tier offers unique benefits and exclusive access.
            </p>
            
            <!-- Package Stats -->
            <div class="flex justify-center items-center mt-8 space-x-8">
                <div class="text-center">
                    <div class="text-2xl font-bold text-pink-400">{{ $event->packages->count() }}</div>
                    <div class="text-sm text-gray-400">Packages</div>
                </div>
                <div class="w-px h-12 bg-gray-600"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-400">{{ $event->packages->sum('available_tickets') ?? 'Unlimited' }}</div>
                    <div class="text-sm text-gray-400">Total Spots</div>
                </div>
                <div class="w-px h-12 bg-gray-600"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-indigo-400">{{ $event->packages->min('price') ? 'KSH ' . number_format($event->packages->min('price')) : 'Varies' }}</div>
                    <div class="text-sm text-gray-400">Starting From</div>
                </div>
            </div>
        </div>
        
        <!-- Packages Grid -->
        <div class="grid grid-cols-1 md:grid-cols-{{ min($event->packages->count(), 3) }} gap-8 lg:gap-12">
            @foreach($event->packages as $index => $package)
            <div class="package-card-modern {{ $index === 1 ? 'featured' : '' }}" data-package="{{ $package->id }}">
                <!-- Package Header -->
                <div class="package-header-modern">
                    @if($index === 1)
                    <div class="featured-badge">
                        <i class="fas fa-crown"></i>
                        Most Popular
                    </div>
                    @endif
                    
                    <div class="package-icon-modern">
                        <span class="icon-emoji">{{ $package->icon ?? '🎫' }}</span>
                    </div>
                    
                    <h3 class="package-title-modern">{{ $package->name }}</h3>
                    
                    <div class="package-price-modern">
                        <div class="price-currency">KSH</div>
                        <div class="price-amount">{{ number_format($package->price) }}</div>
                        @if($package->group_size > 1)
                        <div class="price-detail">for {{ $package->group_size }} {{ $package->group_size > 1 ? 'people' : 'person' }}</div>
                        @endif
                    </div>
                </div>
                
                <!-- Package Features -->
                <div class="package-features">
                    @if($package->description)
                    <p class="package-description-modern">{{ $package->description }}</p>
                    @endif
                    
                    <!-- Feature List -->
                    <ul class="feature-list">
                        <li class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $package->group_size }} {{ $package->group_size > 1 ? 'tickets' : 'ticket' }} included</span>
                        </li>
                        @if($package->group_size > 1)
                        <li class="feature-item">
                            <i class="fas fa-users"></i>
                            <span>Group entry experience</span>
                        </li>
                        @endif
                        <li class="feature-item">
                            <i class="fas fa-music"></i>
                            <span>Full event access</span>
                        </li>
                        @if($index === 1)
                        <li class="feature-item premium">
                            <i class="fas fa-star"></i>
                            <span>Premium perks included</span>
                        </li>
                        @endif
                        @if($index === 2)
                        <li class="feature-item vip">
                            <i class="fas fa-gem"></i>
                            <span>VIP treatment</span>
                        </li>
                        @endif
                    </ul>
                </div>
                
                <!-- Package Footer -->
                <div class="package-footer-modern">
                    @if($package->hasAvailableTickets())
                        <!-- Availability Indicator -->
                        @if($package->available_tickets)
                        <div class="availability-indicator">
                            @php 
                                $remaining = $package->available_tickets - $package->bookings->where('payment_status', 'confirmed')->count();
                                $percentage = ($remaining / $package->available_tickets) * 100;
                            @endphp
                            <div class="availability-bar">
                                <div class="availability-fill" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="availability-text">
                                {{ $remaining }} of {{ $package->available_tickets }} remaining
                            </span>
                        </div>
                        @endif
                        
                        <button onclick="openBookingModal({{ $event->id }}, {{ $package->id }}, '{{ $package->name }}', {{ $package->price }}, {{ $package->group_size }})"
                                class="package-button-modern {{ $index === 1 ? 'featured' : '' }}">
                            <span class="button-text">
                                <i class="fas fa-shopping-cart mr-2"></i>Book Now
                            </span>
                            <div class="button-shine"></div>
                        </button>
                    @else
                        <div class="sold-out-indicator">
                            <i class="fas fa-times-circle"></i>
                            <span>Sold Out</span>
                        </div>
                        <button disabled class="package-button-disabled">
                            <i class="fas fa-ban mr-2"></i>Unavailable
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Additional Info -->
        <div class="mt-16 text-center">
            <div class="inline-flex items-center bg-black/20 backdrop-blur-md rounded-full px-6 py-3 mb-6">
                <i class="fas fa-info-circle text-blue-400 mr-3"></i>
                <span class="text-gray-300">Secure booking • Instant confirmation • 24/7 support</span>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <button onclick="scrollToTop()" class="text-pink-400 hover:text-pink-300 transition-colors duration-300">
                    <i class="fas fa-arrow-up mr-2"></i>Back to Top
                </button>
                <span class="text-gray-500">•</span>
                <button onclick="shareEvent()" class="text-purple-400 hover:text-purple-300 transition-colors duration-300">
                    <i class="fas fa-share-alt mr-2"></i>Share This Event
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Include Booking Modal from Welcome Page -->
@include('partials.booking-modal')

<script>
// Smooth scrolling
function scrollToPackages() {
    document.getElementById('packages-section').scrollIntoView({ 
        behavior: 'smooth' 
    });
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Share event functionality
function shareEvent() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $event->name }}',
            text: '{{ Str::limit($event->description, 100) }}',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification('Event link copied to clipboard!', 'success');
        });
    }
}

// Countdown Timer
function initCountdown() {
    const eventDate = new Date('{{ $event->date->toISOString() }}').getTime();
    const countdownContainer = document.getElementById('countdown');
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = eventDate - now;
        
        if (distance < 0) {
            countdownContainer.innerHTML = '<div class="countdown-item"><span class="countdown-number">Event</span><span class="countdown-label">Started!</span></div>';
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        countdownContainer.innerHTML = `
            <div class="countdown-item">
                <span class="countdown-number">${days}</span>
                <span class="countdown-label">Days</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number">${hours}</span>
                <span class="countdown-label">Hours</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number">${minutes}</span>
                <span class="countdown-label">Minutes</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-number">${seconds}</span>
                <span class="countdown-label">Seconds</span>
            </div>
        `;
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
}

// Booking modal functionality
function openBookingModal(eventId, packageId, packageName, price, groupSize) {
    // Set form values
    document.getElementById('event_id').value = eventId;
    document.getElementById('package_id').value = packageId;
    document.getElementById('group_size').value = groupSize;
    document.getElementById('price').value = price;
    document.getElementById('package_name').textContent = packageName;
    document.getElementById('package_price').textContent = 'KSH ' + price.toLocaleString();
    
    // Handle members section for group bookings
    const membersSection = document.getElementById('membersSection');
    const membersContainer = document.getElementById('membersContainer');
    
    if (groupSize > 1) {
        membersSection.style.display = 'block';
        membersContainer.innerHTML = '';
        
        for (let i = 0; i < groupSize - 1; i++) {
            membersContainer.innerHTML += `
                <div style="background: rgba(255,255,255,0.05); border-radius: 10px; padding: 1rem; margin-bottom: 1rem; border: 1px solid rgba(255,255,255,0.1);">
                    <h5 style="color: white; margin-bottom: 0.75rem;">Member ${i + 2}</h5>
                    <div style="display: grid; gap: 0.75rem;">
                        <input type="text" name="members[${i}][name]" style="width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" placeholder="Full Name" required>
                        <input type="email" name="members[${i}][email]" style="width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" placeholder="Email">
                        <input type="tel" name="members[${i}][phone]" style="width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;" placeholder="Phone">
                    </div>
                </div>
            `;
        }
    } else {
        membersSection.style.display = 'none';
    }
    
    // Show modal
    document.getElementById('bookingModal').style.display = 'flex';
}

function closeBookingModal() {
    document.getElementById('bookingModal').style.display = 'none';
}

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium transform translate-x-full transition-transform duration-300 ${type === 'success' ? 'bg-green-500' : 'bg-blue-500'}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => notification.style.transform = 'translateX(0)', 100);
    setTimeout(() => {
        notification.style.transform = 'translateX(full)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    initCountdown();
    
    // Add scroll effects
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        const heroImage = document.querySelector('.hero-bg-image');
        if (heroImage) {
            heroImage.style.transform = `translate3d(0, ${rate}px, 0)`;
        }
    });
    
    // Close modal on outside click
    document.getElementById('bookingModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeBookingModal();
        }
    });
});

// Add animations on scroll
const observeElements = () => {
    const elements = document.querySelectorAll('.package-card-modern, .event-detail-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    elements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(50px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
};

// Initialize animations
document.addEventListener('DOMContentLoaded', observeElements);
</script>

<style>
/* Floating Particles Animation */
.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: float 10s infinite linear;
}

@keyframes float {
    0% { 
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
    }
    10% { 
        opacity: 1;
    }
    90% { 
        opacity: 1;
    }
    100% { 
        transform: translateY(-100px) rotate(360deg);
        opacity: 0;
    }
}

/* Gradient Animation */
@keyframes gradient-x {
    0%, 100% { background-size: 200% 200%; background-position: left center; }
    50% { background-size: 200% 200%; background-position: right center; }
}

.animate-gradient-x {
    animation: gradient-x 4s ease infinite;
}

/* Event Detail Cards */
.event-detail-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.event-detail-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transition: left 0.5s ease;
}

.event-detail-card:hover::before {
    left: 100%;
}

.event-detail-card:hover {
    transform: translateY(-5px);
    border-color: rgba(255, 46, 99, 0.4);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.event-detail-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #ff2e63, #08d9d6);
    border-radius: 50%;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
    transition: all 0.3s ease;
}

.event-detail-card:hover .event-detail-icon {
    transform: scale(1.1) rotateY(360deg);
}

/* CTA Buttons */
.cta-button-primary {
    background: linear-gradient(135deg, #ff2e63, #08d9d6);
    color: white;
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 10px 30px rgba(255, 46, 99, 0.3);
}

.cta-button-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(255, 46, 99, 0.4);
}

.cta-button-secondary {
    background: transparent;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.cta-button-secondary:hover {
    border-color: rgba(255, 255, 255, 0.6);
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

/* Countdown Timer */
.countdown-item {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1rem;
    padding: 1rem 1.5rem;
    text-align: center;
    min-width: 80px;
}

.countdown-number {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: #ff2e63;
    line-height: 1;
}

.countdown-label {
    display: block;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 0.25rem;
}

/* Modern Package Cards */
.package-card-modern {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 2rem;
    padding: 2rem;
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.package-card-modern.featured {
    border: 2px solid #ff2e63;
    background: linear-gradient(135deg, rgba(255, 46, 99, 0.1), rgba(8, 217, 214, 0.05));
    transform: scale(1.05);
}

.package-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
    border-color: rgba(255, 46, 99, 0.5);
}

.package-card-modern.featured:hover {
    transform: scale(1.05) translateY(-10px);
}

/* Featured Badge */
.featured-badge {
    position: absolute;
    top: -10px;
    right: 20px;
    background: linear-gradient(135deg, #ff2e63, #08d9d6);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 5px 15px rgba(255, 46, 99, 0.3);
}

/* Package Header */
.package-header-modern {
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
}

.package-icon-modern {
    margin-bottom: 1rem;
}

.icon-emoji {
    font-size: 3.5rem;
    display: block;
    filter: drop-shadow(0 0 10px rgba(255, 46, 99, 0.3));
}

.package-title-modern {
    font-size: 1.8rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.package-price-modern {
    margin-bottom: 1.5rem;
}

.price-currency {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.6);
    font-weight: 600;
}

.price-amount {
    font-size: 3rem;
    font-weight: 900;
    background: linear-gradient(135deg, #ff2e63, #08d9d6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    display: block;
}

.price-detail {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
    margin-top: 0.5rem;
}

/* Package Features */
.package-features {
    flex-grow: 1;
    margin-bottom: 2rem;
}

.package-description-modern {
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    margin-bottom: 1.5rem;
    text-align: center;
}

.feature-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.95rem;
}

.feature-item i {
    color: #08d9d6;
    margin-right: 0.75rem;
    width: 16px;
}

.feature-item.premium i {
    color: #ff2e63;
}

.feature-item.vip i {
    color: #8b5cf6;
}

/* Package Footer */
.package-footer-modern {
    margin-top: auto;
}

.availability-indicator {
    margin-bottom: 1rem;
}

.availability-bar {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.availability-fill {
    height: 100%;
    background: linear-gradient(135deg, #08d9d6, #ff2e63);
    transition: width 0.3s ease;
}

.availability-text {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
    text-align: center;
    display: block;
}

/* Package Buttons */
.package-button-modern {
    width: 100%;
    background: linear-gradient(135deg, #ff2e63, #08d9d6);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.package-button-modern.featured {
    background: linear-gradient(135deg, #8b5cf6, #ff2e63);
    box-shadow: 0 10px 30px rgba(139, 92, 246, 0.3);
}

.package-button-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(255, 46, 99, 0.4);
}

.button-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.package-button-modern:hover .button-shine {
    left: 100%;
}

.package-button-disabled {
    width: 100%;
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    cursor: not-allowed;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sold-out-indicator {
    text-align: center;
    color: #ef4444;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .package-card-modern.featured {
        transform: scale(1);
        margin: 1rem 0;
    }
    
    .price-amount {
        font-size: 2.5rem;
    }
    
    .package-title-modern {
        font-size: 1.5rem;
    }
    
    .countdown-item {
        padding: 0.75rem;
        min-width: 70px;
    }
    
    .countdown-number {
        font-size: 1.5rem;
    }
}

/* Smooth animations */
* {
    scroll-behavior: smooth;
}

/* Loading animation for images */
img {
    transition: opacity 0.3s ease;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #ff2e63, #08d9d6);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #08d9d6, #ff2e63);
}
</style>
@endsection