<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <title>About Tiko Iko On - Kenya's Premier Entertainment Experience | Our Story</title>
    <meta name="description" content="Discover the story behind Tiko Iko On - Kenya's ultimate party destination. Learn about our mission to create unforgettable entertainment experiences and connect communities through amazing events.">
    <meta name="keywords" content="Tiko Iko On about, Kenya entertainment company, party organizers Kenya, event management, our story, premium entertainment, party venue Kenya">
    <meta name="author" content="Tiko Iko On">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Tiko Iko On">
    <meta property="og:title" content="About Tiko Iko On - Kenya's Premier Entertainment Experience">
    <meta property="og:description" content="Learn about our mission to create unforgettable entertainment experiences in Kenya. Where vibes come alive!">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:url" content="{{ route('about') }}">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="About Tiko Iko On - Our Story">
    <meta name="twitter:description" content="Kenya's ultimate party destination - creating unforgettable entertainment experiences.">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ route('about') }}">
    
    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AboutPage",
        "mainEntity": {
            "@type": "Organization",
            "name": "Tiko Iko On",
            "description": "Kenya's premier entertainment destination creating unforgettable party experiences",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('images/logo.png') }}",
            "foundingDate": "2024",
            "areaServed": "Kenya",
            "knowsAbout": ["Event Management", "Entertainment", "Party Planning", "VIP Experiences"],
            "slogan": "Where Vibes Come Alive"
        }
    }
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body class="party-theme">
    <!-- Navigation (Same as Homepage) -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <h1>🎆 Tiko Iko On</h1>
                <span class="brand-tagline">Where Vibes Come Alive</span>
            </div>
            <div class="nav-links">
                <a href="/" class="nav-link">Home</a>
                <a href="/events" class="nav-link">Events</a>
                <a href="/about" class="nav-link active">About</a>
                <a href="#contact" class="nav-link">Contact</a>
            </div>
            <div class="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" style="min-height: 70vh;">
        <div class="hero-background">
            <div class="neon-circle circle-1"></div>
            <div class="neon-circle circle-2"></div>
            <div class="neon-circle circle-3"></div>
        </div>
        <div class="hero-content" style="text-align: center; padding-top: 100px;">
            <h1 class="hero-title" style="font-size: 4rem; margin-bottom: 1rem;">
                <span class="neon-text">Our Story</span>
            </h1>
            <p class="hero-description" style="font-size: 1.3rem; max-width: 700px; margin: 0 auto;">
                Born from the Energy of Campus Party Nights
            </p>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="section" style="padding: 80px 20px; background: rgba(37, 42, 52, 0.5);">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px); border-radius: 20px; padding: 60px; margin-bottom: 60px; border: 1px solid rgba(255, 46, 99, 0.2);">
                <p style="font-size: 1.2rem; line-height: 1.8; text-align: center; color: rgba(255, 255, 255, 0.9);">
                    Tiko Iko On started in 2024 when a group of friends realized that our campus events needed a spark. We were tired of the same old venues, predictable playlists, and events that felt more like obligations than celebrations. So we asked ourselves: "What if we could create parties so epic that FOMO becomes a real thing?"
                </p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 40px;">
                    <div style="background: linear-gradient(135deg, rgba(255, 46, 99, 0.1), rgba(8, 217, 214, 0.1)); border-radius: 15px; overflow: hidden; transition: transform 0.3s; border: 1px solid rgba(255, 46, 99, 0.2);">
                        <img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=600" alt="DJ at party" style="width: 100%; height: 250px; object-fit: cover;">
                        <div style="padding: 25px;">
                            <h4 style="font-size: 1.5rem; margin-bottom: 10px; color: #FF2E63; font-family: 'Orbitron', sans-serif;">The Vision</h4>
                            <p>Creating spaces where every beat drops matter, every connection is genuine, and every night becomes a story worth telling</p>
                        </div>
                    </div>
                    
                    <div style="background: linear-gradient(135deg, rgba(8, 217, 214, 0.1), rgba(255, 46, 99, 0.1)); border-radius: 15px; overflow: hidden; transition: transform 0.3s; border: 1px solid rgba(8, 217, 214, 0.2);">
                        <img src="https://images.unsplash.com/photo-1429962714451-bb934ecdc4ec?w=600" alt="Crowd at concert" style="width: 100%; height: 250px; object-fit: cover;">
                        <div style="padding: 25px;">
                            <h4 style="font-size: 1.5rem; margin-bottom: 10px; color: #08D9D6; font-family: 'Orbitron', sans-serif;">The Mission</h4>
                            <p>To redefine party culture in Kenya by blending cutting-edge entertainment with authentic community vibes</p>
                        </div>
                    </div>
                    
                    <div style="background: linear-gradient(135deg, rgba(249, 237, 105, 0.1), rgba(255, 46, 99, 0.1)); border-radius: 15px; overflow: hidden; transition: transform 0.3s; border: 1px solid rgba(249, 237, 105, 0.2);">
                        <img src="https://images.unsplash.com/photo-1574391884720-bbc3740c59d1?w=600" alt="Dance floor lights" style="width: 100%; height: 250px; object-fit: cover;">
                        <div style="padding: 25px;">
                            <h4 style="font-size: 1.5rem; margin-bottom: 10px; color: #F9ED69; font-family: 'Orbitron', sans-serif;">The Promise</h4>
                            <p>Every event we throw is designed to blow your mind and make you question why you ever settled for boring nights out</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 60px;">
                <div style="text-align: center; padding: 30px; background: linear-gradient(135deg, rgba(255, 46, 99, 0.2), rgba(8, 217, 214, 0.2)); border-radius: 15px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 46, 99, 0.3);">
                    <div style="font-size: 3rem; font-weight: bold; font-family: 'Orbitron', sans-serif; color: #FF2E63;">50K+</div>
                    <p>Party  United</p>
                </div>
                <div style="text-align: center; padding: 30px; background: linear-gradient(135deg, rgba(8, 217, 214, 0.2), rgba(255, 46, 99, 0.2)); border-radius: 15px; backdrop-filter: blur(10px); border: 1px solid rgba(8, 217, 214, 0.3);">
                    <div style="font-size: 3rem; font-weight: bold; font-family: 'Orbitron', sans-serif; color: #08D9D6;">200+</div>
                    <p>Epic Events Delivered</p>
                </div>
                <div style="text-align: center; padding: 30px; background: linear-gradient(135deg, rgba(249, 237, 105, 0.2), rgba(255, 46, 99, 0.2)); border-radius: 15px; backdrop-filter: blur(10px); border: 1px solid rgba(249, 237, 105, 0.3);">
                    <div style="font-size: 3rem; font-weight: bold; font-family: 'Orbitron', sans-serif; color: #F9ED69;">98%</div>
                    <p>Would Party Again</p>
                </div>
                <div style="text-align: center; padding: 30px; background: linear-gradient(135deg, rgba(255, 46, 99, 0.2), rgba(8, 217, 214, 0.2)); border-radius: 15px; backdrop-filter: blur(10px); border: 1px solid rgba(255, 46, 99, 0.3);">
                    <div style="font-size: 3rem; font-weight: bold; font-family: 'Orbitron', sans-serif; color: #FF2E63;">24/7</div>
                    <p>Vibe Checking</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section" style="padding: 80px 20px;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <h2 style="font-family: 'Orbitron', sans-serif; font-size: 3rem; text-align: center; margin-bottom: 3rem; background: linear-gradient(45deg, #FF2E63, #08D9D6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Our Values</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                <div style="background: linear-gradient(135deg, rgba(255, 46, 99, 0.15), rgba(8, 217, 214, 0.15)); padding: 40px; border-radius: 20px; text-align: center; backdrop-filter: blur(10px); border: 1px solid rgba(255, 46, 99, 0.2);">
                    <div style="font-size: 4rem; margin-bottom: 20px;">🔥</div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 15px; color: #FF2E63;">Energy First</h3>
                    <p>We bring the heat to every event. No energy, no party. Period.</p>
                </div>
                
                <div style="background: linear-gradient(135deg, rgba(8, 217, 214, 0.15), rgba(255, 46, 99, 0.15)); padding: 40px; border-radius: 20px; text-align: center; backdrop-filter: blur(10px); border: 1px solid rgba(8, 217, 214, 0.2);">
                    <div style="font-size: 4rem; margin-bottom: 20px;">🤝</div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 15px; color: #08D9D6;">Community Vibes</h3>
                    <p>We're building more than events - we're creating a movement of party enthusiasts</p>
                </div>
                
                <div style="background: linear-gradient(135deg, rgba(249, 237, 105, 0.15), rgba(255, 46, 99, 0.15)); padding: 40px; border-radius: 20px; text-align: center; backdrop-filter: blur(10px); border: 1px solid rgba(249, 237, 105, 0.2);">
                    <div style="font-size: 4rem; margin-bottom: 20px;">💎</div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 15px; color: #F9ED69;">Premium Quality</h3>
                    <p>From sound systems to safety protocols, we never compromise on excellence</p>
                </div>
                
                <div style="background: linear-gradient(135deg, rgba(255, 46, 99, 0.15), rgba(8, 217, 214, 0.15)); padding: 40px; border-radius: 20px; text-align: center; backdrop-filter: blur(10px); border: 1px solid rgba(255, 46, 99, 0.2);">
                    <div style="font-size: 4rem; margin-bottom: 20px;">🎯</div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 15px; color: #FF2E63;">Authentic Experiences</h3>
                    <p>Real vibes only. We keep it 100 with our community, always</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section" style="padding: 80px 20px; background: rgba(0,0,0,0.3);">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <h2 style="font-family: 'Orbitron', sans-serif; font-size: 3rem; text-align: center; margin-bottom: 3rem; background: linear-gradient(45deg, #FF2E63, #08D9D6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Moments That Matter</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div style="height: 300px; border-radius: 15px; overflow: hidden; position: relative; border: 2px solid rgba(255, 46, 99, 0.3);">
                    <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600" alt="Concert crowd" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                </div>
                <div style="height: 300px; border-radius: 15px; overflow: hidden; position: relative; border: 2px solid rgba(8, 217, 214, 0.3);">
                    <img src="https://images.unsplash.com/photo-1459749411175-04bf5292ceea?w=600" alt="DJ performing" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                </div>
                <div style="height: 300px; border-radius: 15px; overflow: hidden; position: relative; border: 2px solid rgba(249, 237, 105, 0.3);">
                    <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600" alt="Party lights" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="background: linear-gradient(135deg, #FF2E63, #08D9D6); text-align: center; padding: 80px 20px;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <h2 style="font-size: 3rem; margin-bottom: 20px; font-family: 'Orbitron', sans-serif;">Ready to Experience the Difference?</h2>
            <p style="font-size: 1.3rem; margin-bottom: 40px; opacity: 0.95;">
                Join thousands of party lovers who've already discovered what makes Tiko Iko On the talk of Nairobi
            </p>
            <a href="/" style="display: inline-block; background: white; color: #FF2E63; padding: 20px 50px; border-radius: 50px; font-size: 1.3rem; font-weight: bold; text-decoration: none; transition: transform 0.3s; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">Explore Upcoming Events</a>
        </div>
    </section>

    @include('partials.footer')
</body>
</html>