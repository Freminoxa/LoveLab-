<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎆 Tiko Iko On - Ultimate Party Experience</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body class="party-theme">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <h1>🎆 Tiko Iko On</h1>
                <span class="brand-tagline">Where Vibes Come Alive</span>
            </div>
            <div class="nav-links">
                <a href="#home" class="nav-link active">Home</a>
                <a href="#events" class="nav-link">Events</a>
                <a href="#about" class="nav-link">About</a>
                <a href="#contact" class="nav-link">Contact</a>
            </div>
            <div class="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Success Message -->
    @if (session('success'))
        <div class="success-notification" style="position: fixed; top: 80px; right: 20px; z-index: 9999; background: linear-gradient(135deg, #00ff87, #60efff); padding: 20px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); animation: slideIn 0.5s ease;">
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background">
            <div class="neon-circle circle-1"></div>
            <div class="neon-circle circle-2"></div>
            <div class="neon-circle circle-3"></div>
        </div>
        <div class="hero-content">
            <h1 class="hero-title">
                <span class="neon-text">Tiko Iko On</span>
                <span class="subtitle">Ultimate Party Experience</span>
            </h1>
            <p class="hero-description">
                Join the most exclusive events in town. From intimate vibes to massive celebrations - 
                we've got your perfect party waiting! 🔥
            </p>
            <div class="hero-stats">
                <div class="stat">
                    <span class="stat-number">10K+</span>
                    <span class="stat-label">Happy Partiers</span>
                </div>
                <div class="stat">
                    <span class="stat-number">{{ count($events) }}+</span>
                    <span class="stat-label">Epic Events</span>
                </div>
                <div class="stat">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Good Vibes</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="pricing-section" id="events">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">🎊 Upcoming Events</h2>
                <p class="section-subtitle">Every ticket is a gateway to unforgettable memories ✨</p>
            </div>
            
            <div class="pricing-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; padding: 2rem 0;">
                @forelse($events as $event)
                <div class="pricing-card vip-card" data-plan="{{ $event->name }}" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.1), rgba(255, 20, 147, 0.1)); backdrop-filter: blur(10px); border-radius: 20px; overflow: hidden; border: 2px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease;">
                    <!-- Event Poster -->
                    <div style="position: relative; height: 250px; background: linear-gradient(135deg, #667eea, #764ba2); overflow: hidden;">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" 
                                 alt="{{ $event->name }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; font-size: 4rem; color: rgba(255,255,255,0.3);">
                                <i class="fas fa-calendar-star"></i>
                            </div>
                        @endif
                        <div style="position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #ff2e63, #ff6b6b); color: white; padding: 8px 15px; border-radius: 20px; font-weight: bold; font-size: 0.9rem; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                            <i class="fas fa-calendar-alt mr-1"></i>{{ $event->date->format('M d') }}
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="card-header" style="padding: 1.5rem;">
                        <h3 class="plan-name" style="font-size: 1.8rem; font-weight: bold; background: linear-gradient(135deg, #00ff87, #60efff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.5rem;">
                            {{ $event->name }}
                        </h3>
                        <p style="color: rgba(255,255,255,0.7); margin: 0.5rem 0;">
                            <i class="fas fa-map-marker-alt" style="color: #ff2e63;"></i> {{ $event->location }}
                        </p>
                        <p style="color: rgba(255,255,255,0.7); margin: 0.5rem 0;">
                            <i class="fas fa-clock" style="color: #00ff87;"></i> {{ $event->date->format('l, F j, Y - g:i A') }}
                        </p>
                        @if($event->description)
                        <p class="plan-subtitle" style="color: rgba(255,255,255,0.6); margin-top: 1rem; font-size: 0.95rem;">
                            {{ Str::limit($event->description, 100) }}
                        </p>
                        @endif
                    </div>

                    <!-- Ticket Packages -->
                    <div class="pricing-options" style="padding: 0 1.5rem 1.5rem;">
                        @foreach($event->packages as $package)
                        <div class="pricing-option" style="background: linear-gradient(135deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02)); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; margin-bottom: 0.75rem; cursor: pointer; transition: all 0.3s ease;" 
                             onmouseover="this.style.transform='translateX(5px)'; this.style.borderColor='rgba(0,255,135,0.5)'" 
                             onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='rgba(255,255,255,0.1)'"
                             onclick="bookTicket({{ $event->id }}, {{ $package->id }}, '{{ $package->name }}', {{ $package->price }}, {{ $package->group_size }})">
                            <div class="option-content" style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div class="option-icon" style="font-size: 1.8rem;">{{ $package->icon ?? '🎫' }}</div>
                                    <div class="option-info">
                                        <h4 style="color: white; font-size: 1.1rem; font-weight: 600; margin: 0;">{{ $package->name }}</h4>
                                        <span class="tickets" style="color: rgba(255,255,255,0.6); font-size: 0.9rem;">
                                            {{ $package->group_size }} ticket{{ $package->group_size > 1 ? 's' : '' }}
                                            @if($package->available_tickets)
                                                • {{ $package->available_tickets - $package->bookings()->where('payment_status', 'confirmed')->count() }} left
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <p class="price" style="font-size: 1.5rem; font-weight: bold; background: linear-gradient(135deg, #ff2e63, #ff6b6b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0;">
                                        {{ number_format($package->price) }} KSH
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem; background: linear-gradient(135deg, rgba(138, 43, 226, 0.1), rgba(255, 20, 147, 0.1)); border-radius: 20px; border: 2px dashed rgba(255,255,255,0.2);">
                    <i class="fas fa-calendar-times" style="font-size: 4rem; color: rgba(255,255,255,0.3); margin-bottom: 1rem;"></i>
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 0.5rem;">No Events Yet</h3>
                    <p style="color: rgba(255,255,255,0.6);">Check back soon for amazing parties! 🎉</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Booking Modal -->
    <div id="bookingModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.9); backdrop-filter: blur(10px); z-index: 9999; align-items: center; justify-content: center; padding: 1rem;">
        <div style="background: linear-gradient(135deg, #1e1e2e, #2d2d44); border-radius: 25px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; border: 2px solid rgba(255,255,255,0.1); box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
            <div style="position: sticky; top: 0; background: linear-gradient(135deg, #ff2e63, #764ba2); padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; z-index: 10;">
                <h3 style="color: white; font-size: 1.8rem; font-weight: bold; margin: 0;">🎫 Book Your Ticket</h3>
                <button onclick="closeBookingModal()" style="background: none; border: none; color: white; font-size: 2rem; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            
            <form id="bookingForm" method="POST" action="{{ route('submit.booking') }}" style="padding: 2rem;">
                @csrf
                <input type="hidden" name="event_id" id="event_id">
                <input type="hidden" name="package_id" id="package_id">
                <input type="hidden" name="group_size" id="group_size">
                <input type="hidden" name="price" id="price">

                <div style="background: linear-gradient(135deg, rgba(0,255,135,0.1), rgba(96,239,255,0.1)); border-radius: 15px; padding: 1.5rem; margin-bottom: 2rem; border: 1px solid rgba(255,255,255,0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: center; color: white;">
                        <span id="package_name" style="font-size: 1.2rem; font-weight: 600;"></span>
                        <span id="package_price" style="font-size: 1.8rem; font-weight: bold; background: linear-gradient(135deg, #00ff87, #60efff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></span>
                    </div>
                </div>

                <h4 style="color: #00ff87; font-size: 1.3rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-user-circle"></i> Your Information
                </h4>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; font-weight: 500;">Full Name</label>
                    <input type="text" name="team_lead_name" required 
                           style="width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-size: 1rem;"
                           placeholder="Enter your full name">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; font-weight: 500;">Email Address</label>
                    <input type="email" name="team_lead_email" required 
                           style="width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-size: 1rem;"
                           placeholder="your@email.com">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; font-weight: 500;">Phone Number</label>
                    <input type="tel" name="team_lead_phone" required 
                           style="width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-size: 1rem;"
                           placeholder="+254 7XX XXX XXX">
                </div>

                <div id="membersSection" style="display: none; margin-bottom: 1.5rem;">
                    <h4 style="color: #60efff; font-size: 1.3rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-users"></i> Additional Members
                    </h4>
                    <div id="membersContainer"></div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="button" onclick="closeBookingModal()" 
                            style="flex: 1; background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); padding: 1rem; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                        Cancel
                    </button>
                    <button type="submit" 
                            style="flex: 1; background: linear-gradient(135deg, #ff2e63, #764ba2); color: white; border: none; padding: 1rem; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                        Proceed to Payment →
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>🎆 Tiko Iko On</h3>
                    <p>Creating unforgettable party experiences for the next generation.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#events">Events</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <ul>
                        <li><i class="fas fa-phone"></i> +254 700 000 000</li>
                        <li><i class="fas fa-envelope"></i> hello@tikoikoon.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Nairobi, Kenya</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Tiko Iko On. All rights reserved. | Built with ❤️ for Gen Z</p>
            </div>
        </div>
    </footer>

    <script>
        function bookTicket(eventId, packageId, packageName, price, groupSize) {
            document.getElementById('event_id').value = eventId;
            document.getElementById('package_id').value = packageId;
            document.getElementById('group_size').value = groupSize;
            document.getElementById('price').value = price;
            document.getElementById('package_name').textContent = packageName;
            document.getElementById('package_price').textContent = 'KSH ' + price.toLocaleString();
            
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
                                <input type="text" name="members[${i}][name]" 
                                       style="width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;"
                                       placeholder="Full Name" required>
                                <input type="email" name="members[${i}][email]" 
                                       style="width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;"
                                       placeholder="Email">
                                <input type="tel" name="members[${i}][phone]" 
                                       style="width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: white;"
                                       placeholder="Phone">
                            </div>
                        </div>
                    `;
                }
            } else {
                membersSection.style.display = 'none';
            }
            
            const modal = document.getElementById('bookingModal');
            modal.style.display = 'flex';
        }
        
        function closeBookingModal() {
            document.getElementById('bookingModal').style.display = 'none';
        }

        // Close modal on outside click
        document.getElementById('bookingModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingModal();
            }
        });

        // Auto-hide success message
        setTimeout(() => {
            const notification = document.querySelector('.success-notification');
            if (notification) {
                notification.style.animation = 'slideOut 0.5s ease';
                setTimeout(() => notification.remove(), 500);
            }
        }, 5000);
    </script>

    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    </style>
</body>
</html>