<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>Tiko Iko On - Ultimate Party Experience | Premium Events & Entertainment in Kenya</title>
    <meta name="description" content="Experience the ultimate party atmosphere at Tiko Iko On - Kenya's premier event destination. Book exclusive VIP packages, group events, and unforgettable entertainment experiences.">
    <meta name="keywords" content="Tiko Iko On, parties Kenya, events Kenya, entertainment, VIP packages, group bookings, nightlife, premium events, party venue, event booking, Kenya entertainment">
    <meta name="author" content="Tiko Iko On">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    
    <!-- Open Graph Meta Tags for Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Tiko Iko On">
    <meta property="og:title" content="Tiko Iko On - Ultimate Party Experience | Premium Events Kenya">
    <meta property="og:description" content="Join the most exclusive events in Kenya. From intimate vibes to massive celebrations - we've got your perfect party waiting! 🔥">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@tikookeon">
    <meta name="twitter:title" content="Tiko Iko On - Ultimate Party Experience">
    <meta name="twitter:description" content="Experience Kenya's premier entertainment destination. Book exclusive events and VIP packages.">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('/') }}">
    
    <!-- Additional SEO Tags -->
    <meta name="theme-color" content="#ff2e63">
    <meta name="msapplication-navbutton-color" content="#ff2e63">
    <meta name="apple-mobile-web-app-status-bar-style" content="#ff2e63">
    
    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Tiko Iko On",
        "description": "Ultimate Party Experience - Kenya's premier event destination",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "sameAs": [
            "https://facebook.com/tikookeon",
            "https://twitter.com/tikookeon",
            "https://instagram.com/tikookeon"
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "Customer Service",
            "areaServed": "KE",
            "availableLanguage": "English"
        }
    }
    </script>
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "EventSeries",
        "name": "Tiko Iko On Events",
        "description": "Premium entertainment events and party experiences in Kenya",
        "organizer": {
            "@type": "Organization",
            "name": "Tiko Iko On"
        },
        "location": {
            "@type": "Place",
            "addressCountry": "KE"
        }
    }
    </script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body class="party-theme" itemscope itemtype="https://schema.org/WebPage">
    <!-- Navigation -->
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <div class="nav-container">
            <div class="nav-brand">
                <h1 style="display:flex; align-items:center; gap:10px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Tiko Iko On Logo - Kenya's Premier Entertainment Experience" style="height:50px; margin-right:0;">
                    <span itemprop="name">Tiko Iko On</span>
                </h1>
                <span class="brand-tagline" itemprop="slogan">Where Vibes Come Alive</span>
            </div>
            <div class="nav-links">
                <a href="#home" class="nav-link active" aria-current="page">Home</a>
                <a href="#events" class="nav-link">Events</a>
                <a href="{{ route('about') }}" class="nav-link">About</a>
                <a href="#contact" class="nav-link">Contact</a>
            </div>
            <div class="nav-toggle" aria-label="Toggle navigation menu" role="button" tabindex="0">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu" role="navigation" aria-label="Mobile navigation menu">
            <a href="#home" class="mobile-nav-link" role="menuitem">
                <i class="fas fa-home" aria-hidden="true"></i>
                <span>Home</span>
            </a>
            <a href="#events" class="mobile-nav-link" role="menuitem">
                <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                <span>Events</span>
            </a>
            <a href="{{ route('about') }}" class="mobile-nav-link" role="menuitem">
                <i class="fas fa-info-circle" aria-hidden="true"></i>
                <span>About</span>
            </a>
            <a href="#contact" class="mobile-nav-link" role="menuitem">
                <i class="fas fa-envelope" aria-hidden="true"></i>
                <span>Contact</span>
            </a>
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

    <!-- Hero Section -->
    <main>
        <section class="hero" id="home" role="banner" itemscope itemtype="https://schema.org/Organization">
            <div class="hero-background">
                <div class="neon-circle circle-1"></div>
                <div class="neon-circle circle-2"></div>
                <div class="neon-circle circle-3"></div>
            </div>
            <div class="hero-content">
                <h1 class="hero-title" itemprop="name">
                    <span class="neon-text">Tiko Iko On</span>
                    <span class="subtitle" itemprop="slogan">Ultimate Party Experience</span>
                </h1>
                <p class="hero-description" itemprop="description">
                    Join the most exclusive events in Kenya. From intimate vibes to massive celebrations - 
                    we've got your perfect party waiting! 🔥 Experience premium entertainment and unforgettable memories.
                </p>
                <div class="hero-stats" role="region" aria-label="Company statistics">
                    <div class="stat" itemscope itemtype="https://schema.org/QuantitativeValue">
                        <span class="stat-number" itemprop="value">10K+</span>
                        <span class="stat-label" itemprop="description">Happy Partiers</span>
                    </div>
                    <div class="stat" itemscope itemtype="https://schema.org/QuantitativeValue">
                        <span class="stat-number" itemprop="value">{{ count($events) }}+</span>
                        <span class="stat-label" itemprop="description">Epic Events</span>
                    </div>
                    <div class="stat" itemscope itemtype="https://schema.org/QuantitativeValue">
                        <span class="stat-number" itemprop="value">24/7</span>
                        <span class="stat-label" itemprop="description">Good Vibes</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Events Section -->
        <section class="pricing-section content-section" id="events" role="main" aria-labelledby="events-heading">
            <div class="container">
                <header class="section-header">
                    <h2 id="events-heading" class="section-title">🎊 Upcoming Events in Kenya</h2>
                    <p class="section-subtitle">Every ticket is a gateway to unforgettable memories ✨ Premium entertainment experiences await you</p>
                </header>
                
                <div class="pricing-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; padding: 2rem 0;" role="region" aria-label="Available events">
                    @forelse($events as $event)
                    <article class="pricing-card vip-card" data-plan="{{ $event->name }}" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.1), rgba(255, 20, 147, 0.1)); backdrop-filter: blur(10px); border-radius: 20px; overflow: hidden; border: 2px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease;" 
                             itemscope itemtype="https://schema.org/Event">
                        <!-- Event Poster -->
                        <div style="position: relative; height: 250px; background: linear-gradient(135deg, #667eea, #764ba2); overflow: hidden;">
                            @if($event->poster)
                                <img src="{{ asset('storage/' . $event->poster) }}" 
                                     alt="{{ $event->name }} event poster - Premium entertainment in Kenya" 
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     itemprop="image">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; font-size: 4rem; color: rgba(255,255,255,0.3);">
                                    <i class="fas fa-calendar-star" aria-label="Event icon"></i>
                                </div>
                            @endif
                            <div style="position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #ff2e63, #ff6b6b); color: white; padding: 8px 15px; border-radius: 20px; font-weight: bold; font-size: 0.9rem; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                                <i class="fas fa-calendar-alt mr-1" aria-hidden="true"></i><time datetime="{{ $event->date->format('Y-m-d') }}" itemprop="startDate">{{ $event->date->format('M d') }}</time>
                            </div>
                    </div>

                        <!-- Event Details -->
                        <header class="card-header" style="padding: 1.5rem;">
                            <h3 class="plan-name" style="font-size: 1.8rem; font-weight: bold; background: linear-gradient(135deg, #00ff87, #60efff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.5rem;" itemprop="name">
                                {{ $event->name }}
                            </h3>
                            <div style="color: rgba(255,255,255,0.7); margin: 0.5rem 0;" itemprop="location" itemscope itemtype="https://schema.org/Place">
                                <i class="fas fa-map-marker-alt" style="color: #ff2e63;" aria-hidden="true"></i> <span itemprop="name">{{ $event->location ?? $event->venue }}</span>
                            </div>
                            <time style="color: rgba(255,255,255,0.7); margin: 0.5rem 0;" itemprop="startDate" datetime="{{ $event->date->format('Y-m-d\TH:i:s') }}">
                                <i class="fas fa-clock" style="color: #00ff87;" aria-hidden="true"></i> {{ $event->date->format('l, F j, Y - g:i A') }}
                            </time>
                            @if($event->description)
                            <p class="plan-subtitle" style="color: rgba(255,255,255,0.6); margin-top: 1rem; font-size: 0.95rem;" itemprop="description">
                                {{ Str::limit($event->description, 100) }}
                            </p>
                            @endif
                            
                            <!-- Event Organization Info -->
                            <meta itemprop="organizer" content="Tikoikoon Events">
                            <meta itemprop="eventStatus" content="https://schema.org/EventScheduled">
                            <meta itemprop="eventAttendanceMode" content="https://schema.org/OfflineEventAttendanceMode">
                        </header>

                        <!-- Ticket Packages -->
                        <div class="pricing-options" style="padding: 0 1.5rem 1.5rem;" role="list" aria-label="Available ticket packages">
                            @foreach($event->packages as $package)
                            <div class="pricing-option" style="background: linear-gradient(135deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02)); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem; margin-bottom: 0.75rem; cursor: pointer; transition: all 0.3s ease;" 
                                 onmouseover="this.style.transform='translateX(5px)'; this.style.borderColor='rgba(0,255,135,0.5)'" 
                                 onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='rgba(255,255,255,0.1)'"
                                 onclick="bookTicket({{ $event->id }}, {{ $package->id }}, '{{ $package->name }}', {{ $package->price }}, {{ $package->group_size }})"
                                 role="listitem" itemscope itemtype="https://schema.org/Offer"
                                 aria-label="Book {{ $package->name }} ticket package">
                                <div class="option-content" style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div class="option-icon" style="font-size: 1.8rem;" aria-hidden="true">{{ $package->icon ?? '🎫' }}</div>
                                        <div class="option-info">
                                            <h4 style="color: white; font-size: 1.1rem; font-weight: 600; margin: 0;" itemprop="name">{{ $package->name }}</h4>
                                            <span class="tickets" style="color: rgba(255,255,255,0.6); font-size: 0.9rem;" itemprop="description">
                                                {{ $package->group_size }} ticket{{ $package->group_size > 1 ? 's' : '' }}
                                                @if($package->available_tickets)
                                                    • {{ $package->available_tickets - $package->bookings()->where('payment_status', 'confirmed')->count() }} left
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <p class="price" style="font-size: 1.5rem; font-weight: bold; background: linear-gradient(135deg, #ff2e63, #ff6b6b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0;" 
                                           itemprop="price" content="{{ $package->price }}">
                                            <span itemprop="priceCurrency" content="KES">{{ number_format($package->price) }} KSH</span>
                                        </p>
                                        <meta itemprop="availability" content="https://schema.org/InStock">
                                        <meta itemprop="validFrom" content="{{ now()->toISOString() }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </article>
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

    <!-- Past Events Showcase Section -->
    @if($pastEvents->count() > 0)
    <section class="past-events-section content-section" style="padding: 6rem 0; background: linear-gradient(135deg, #0f0f23, #1a1a2e); position: relative; overflow: hidden;" role="region" aria-labelledby="past-events-heading">
        <!-- Background Effects -->
        <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(255, 107, 107, 0.1), transparent); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(96, 239, 255, 0.08), transparent); border-radius: 50%; animation: float 8s ease-in-out infinite reverse;"></div>
        
        <div class="container" style="position: relative; z-index: 2;">
            <header class="section-header" style="text-align: center; margin-bottom: 4rem;">
                <h2 id="past-events-heading" class="section-title" style="font-size: 3rem; font-weight: 800; background: linear-gradient(135deg, #ff6b6b, #ffd93d, #6bcf7f); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 1rem;">
                    🎉 Epic Memories Created
                </h2>
                <p class="section-subtitle" style="font-size: 1.3rem; color: rgba(255,255,255,0.8); max-width: 600px; margin: 0 auto; line-height: 1.6;">
                    Relive the magic of our previous events! Here's where legends were made and memories were born ✨
                </p>
            </header>
            
            <div class="past-events-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(380px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                @foreach($pastEvents as $event)
                <article class="past-event-card" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02)); backdrop-filter: blur(15px); border-radius: 25px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.4s ease; position: relative; cursor: pointer;" 
                         onmouseover="this.style.transform='translateY(-10px) scale(1.02)'; this.style.boxShadow='0 25px 60px rgba(0,0,0,0.3)'; this.style.borderColor='rgba(255,107,107,0.5)'" 
                         onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'; this.style.borderColor='rgba(255,255,255,0.1)'"
                         onclick="window.location.href='/{{ str_replace(' ', '-', strtolower($event->name)) }}'"
                         itemscope itemtype="https://schema.org/Event">
                    
                    <!-- Event Status Badge -->
                    <div style="position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, #4caf50, #45a049); color: white; padding: 8px 16px; border-radius: 20px; font-weight: bold; font-size: 0.85rem; z-index: 3; box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);">
                        <i class="fas fa-check-circle" aria-hidden="true"></i> Event Completed
                    </div>
                    
                    <!-- Attendance Badge -->
                    @php
                        $totalBookings = $event->bookings->where('payment_status', 'confirmed')->count();
                        $attendedCount = $event->bookings->where('payment_status', 'confirmed')->where('has_attended', true)->count();
                    @endphp
                    @if($totalBookings > 0)
                    <div style="position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #ff9800, #f57c00); color: white; padding: 8px 16px; border-radius: 20px; font-weight: bold; font-size: 0.85rem; z-index: 3; box-shadow: 0 5px 15px rgba(255, 152, 0, 0.3);">
                        <i class="fas fa-users" aria-hidden="true"></i> {{ $attendedCount }}/{{ $totalBookings }} Attended
                    </div>
                    @endif
                    
                    <!-- Event Image -->
                    <div style="position: relative; height: 250px; background: linear-gradient(135deg, #667eea, #764ba2); overflow: hidden;">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" 
                                 alt="{{ $event->name }} - Past event at {{ $event->venue }}" 
                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                                 onmouseover="this.style.transform='scale(1.1)'" 
                                 onmouseout="this.style.transform='scale(1)'"
                                 itemprop="image">
                        @else
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; font-size: 4rem; color: rgba(255,255,255,0.3);">
                                <i class="fas fa-calendar-check" aria-label="Completed event icon"></i>
                            </div>
                        @endif
                        
                        <!-- Gradient Overlay -->
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; background: linear-gradient(transparent, rgba(0,0,0,0.8)); pointer-events: none;"></div>
                    </div>
                    
                    <!-- Event Details -->
                    <div style="padding: 2rem;">
                        <!-- Event Title -->
                        <header style="margin-bottom: 1.5rem;">
                            <h3 style="font-size: 1.8rem; font-weight: 700; background: linear-gradient(135deg, #ff6b6b, #ffd93d); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.8rem;" itemprop="name">
                                {{ $event->name }}
                            </h3>
                            
                            <!-- Event Info Grid -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div style="display: flex; align-items: center; color: rgba(255,255,255,0.7); font-size: 0.95rem;" itemprop="location" itemscope itemtype="https://schema.org/Place">
                                    <i class="fas fa-map-marker-alt" style="color: #ff6b6b; margin-right: 8px; width: 16px;" aria-hidden="true"></i>
                                    <span itemprop="name">{{ $event->venue }}</span>
                                </div>
                                <time style="display: flex; align-items: center; color: rgba(255,255,255,0.7); font-size: 0.95rem;" itemprop="startDate" datetime="{{ $event->date->format('Y-m-d') }}">
                                    <i class="fas fa-calendar" style="color: #4ecdc4; margin-right: 8px; width: 16px;" aria-hidden="true"></i>
                                    {{ $event->date->format('M j, Y') }}
                                </time>
                            </div>
                        </header>
                        
                        <!-- Event Description -->
                        @if($event->description)
                        <p style="color: rgba(255,255,255,0.6); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;" itemprop="description">
                            {{ Str::limit($event->description, 120) }}
                        </p>
                        @endif
                        
                        <!-- Event Stats -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                            @if($event->packages->count() > 0)
                            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 1rem; text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: bold; color: #00ff87; margin-bottom: 0.3rem;">
                                    {{ $event->packages->count() }}
                                </div>
                                <div style="font-size: 0.85rem; color: rgba(255,255,255,0.6);">
                                    Package{{ $event->packages->count() > 1 ? 's' : '' }}
                                </div>
                            </div>
                            @endif
                            
                            @if($totalBookings > 0)
                            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 1rem; text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: bold; color: #ff6b6b; margin-bottom: 0.3rem;">
                                    {{ $totalBookings }}
                                </div>
                                <div style="font-size: 0.85rem; color: rgba(255,255,255,0.6);">
                                    Ticket{{ $totalBookings > 1 ? 's' : '' }} Sold
                                </div>
                            </div>
                            @endif
                            
                            @if($attendedCount > 0)
                            <div style="background: rgba(255, 255, 255, 0.05); border-radius: 12px; padding: 1rem; text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: bold; color: #ffd93d; margin-bottom: 0.3rem;">
                                    {{ number_format(($attendedCount / $totalBookings) * 100) }}%
                                </div>
                                <div style="font-size: 0.85rem; color: rgba(255,255,255,0.6);">
                                    Attendance
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Price Range -->
                        @if($event->packages->count() > 0)
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                            <span style="color: rgba(255,255,255,0.6); font-size: 0.9rem;">
                                Event Tickets Were:
                            </span>
                            <span style="font-size: 1.2rem; font-weight: bold; background: linear-gradient(135deg, #ff6b6b, #ffd93d); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                KSh {{ number_format($event->packages->min('price')) }} - {{ number_format($event->packages->max('price')) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>
            
            <!-- View More Past Events Button -->
            <div style="text-align: center;">
                <button onclick="showAllPastEvents()" style="background: linear-gradient(135deg, #ff6b6b, #ffd93d); color: white; border: none; padding: 1rem 2.5rem; border-radius: 25px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);" 
                       onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 35px rgba(255, 107, 107, 0.4)'" 
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(255, 107, 107, 0.3)'">
                    <i class="fas fa-history" aria-hidden="true"></i> View All Past Events
                </button>
            </div>
        </div>
    </section>
    @endif

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
                    <label style="display: block; color: rgba(255,255,255,0.8); margin-bottom: 0.5rem; font-weight: 500;">Mpesa Name</label>
                    <input type="text" name="team_lead_name" required 
                           style="width: 100%; padding: 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-size: 1rem;"
                           placeholder="Enter your mpesa name">
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

    @include('partials.footer')

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
        });
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
                notification.style.animation = 'slideOut 0.9s ease';
                setTimeout(() => notification.remove(), 500);
            }
        }, 5000);
        
        // Show all past events function
        function showAllPastEvents() {
            // You can implement this to redirect to a dedicated past events page
            // or expand the current section to show more events
            alert('This feature will show all past events in a dedicated page or expanded view!');
            // Example: window.location.href = '/past-events';
        }
        
        // Add smooth scrolling for navigation links
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
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        /* Past events section specific styles */
        .past-event-card {
            position: relative;
        }
        .past-event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            background-size: 200% 200%;
            animation: shimmer 3s infinite;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 25px;
            pointer-events: none;
        }
        .past-event-card:hover::before {
            opacity: 1;
        }
        
        /* Responsive design for past events */
        @media (max-width: 768px) {
            .past-events-grid {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }
            .past-event-card {
                margin: 0 1rem;
            }
            .section-title {
                font-size: 2rem !important;
            }
            .section-subtitle {
                font-size: 1.1rem !important;
            }
        }
    </style>
</body>
</html>
