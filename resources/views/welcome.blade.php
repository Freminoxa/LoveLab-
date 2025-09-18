<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiko Iko On - Party Tickets</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
            <div class="pricing-grid">
                @foreach($events as $event)
                    <div class="pricing-card" data-plan="{{ $event->name }}">
                        <div class="card-header">
                            <div class="plan-icon">{{ $event->icon ?? '🎉' }}</div>
                            <h3 class="plan-name">{{ $event->name }}</h3>
                            <p class="plan-subtitle">{{ $event->description }}</p>
                        </div>
                        <div class="pricing-options">
                            <div class="pricing-option" data-size="{{ $event->group_size }}" data-price="{{ $event->price }}">
                                <div class="option-content">
                                    <div class="option-icon">{{ $event->option_icon ?? '👤' }}</div>
                                    <div class="option-info">
                                        <h4>{{ $event->option_name ?? 'Ticket' }}</h4>
                                        <p class="price">{{ number_format($event->price) }} KSH</p>
                                        <span class="tickets">{{ $event->group_size }} ticket{{ $event->group_size > 1 ? 's' : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Epic Events</span>
                </div>
                <div class="stat">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Good Vibes</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section" id="events">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Choose Your Vibe</h2>
                <p class="section-subtitle">Every ticket is a gateway to unforgettable memories ✨</p>
            </div>
            
            <div class="pricing-grid">
                <!-- IP Plan -->
                <div class="pricing-card ip-card" data-plan="IP">
                    <div class="card-header">
                        <div class="plan-icon">🎵</div>
                        <h3 class="plan-name">IP</h3>
                        <p class="plan-subtitle">Essential Vibes</p>
                    </div>
                    <div class="pricing-options">
                        <div class="pricing-option" data-size="1" data-price="500">
                            <div class="option-content">
                                <div class="option-icon">👤</div>
                                <div class="option-info">
                                    <h4>Solo Rider</h4>
                                    <p class="price">500 KSH</p>
                                    <span class="tickets">1 ticket</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-option" data-size="2" data-price="800">
                            <div class="option-content">
                                <div class="option-icon">💕</div>
                                <div class="option-info">
                                    <h4>Couple Goals</h4>
                                    <p class="price">800 KSH</p>
                                    <span class="tickets">2 tickets</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-option" data-size="6" data-price="1500">
                            <div class="option-content">
                                <div class="option-icon">👥</div>
                                <div class="option-info">
                                    <h4>Squad Up</h4>
                                    <p class="price">1,500 KSH</p>
                                    <span class="tickets">6 tickets</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-option" data-size="10" data-price="2500">
                            <div class="option-content">
                                <div class="option-icon">🎉</div>
                                <div class="option-info">
                                    <h4>Party Pack</h4>
                                    <p class="price">2,500 KSH</p>
                                    <span class="tickets">10 tickets</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VIP Plan -->
                <div class="pricing-card vip-card" data-plan="VIP">
                    <div class="card-header">
                        <div class="plan-icon">⭐</div>
                        <h3 class="plan-name">VIP</h3>
                        <p class="plan-subtitle">Premium Experience</p>
                        <div class="popular-badge">Most Popular</div>
                    </div>
                    <div class="pricing-options">
                        <div class="pricing-option" data-size="1" data-price="1000">
                            <div class="option-content">
                                <div class="option-icon">👤</div>
                                <div class="option-info">
                                    <h4>Solo VIP</h4>
                                    <p class="price">1,000 KSH</p>
                                    <span class="tickets">1 ticket</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-option" data-size="2" data-price="1800">
                            <div class="option-content">
                                <div class="option-icon">💕</div>
                                <div class="option-info">
                                    <h4>VIP Duo</h4>
                                    <p class="price">1,800 KSH</p>
                                    <span class="tickets">2 tickets</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-option" data-size="6" data-price="4500">
                            <div class="option-content">
                                <div class="option-icon">👥</div>
                                <div class="option-info">
                                    <h4>VIP Squad</h4>
                                    <p class="price">4,500 KSH</p>
                                    <span class="tickets">6 tickets</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-option" data-size="10" data-price="7500">
                            <div class="option-content">
                                <div class="option-icon">🎉</div>
                                <div class="option-info">
                                    <h4>VIP Crew</h4>
                                    <p class="price">7,500 KSH</p>
                                    <span class="tickets">10 tickets</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VVIP Plan -->
                <div class="pricing-card vvip-card" data-plan="VVIP">
                    <div class="card-header">
                        <div class="plan-icon">💎</div>
                        <h3 class="plan-name">VVIP</h3>
                        <p class="plan-subtitle">Luxury Lifestyle</p>
                    </div>
                    <div class="pricing-options">
                        <div class="pricing-option" data-size="1" data-price="2500">
                            <div class="option-content">
                                <div class="option-icon">👤</div>
                                <div class="option-info">
                                    <h4>Elite Solo</h4>
                                    <p class="price">2,500 KSH</p>
                                    <span class="tickets">1 ticket</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-option" data-size="2" data-price="4800">
                            <div class="option-content">
                                <div class="option-icon">💕</div>
                                <div class="option-info">
                                    <h4>Elite Pair</h4>
                                    <p class="price">4,800 KSH</p>
                                    <span class="tickets">2 tickets</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-option" data-size="6" data-price="13500">
                            <div class="option-content">
                                <div class="option-icon">👥</div>
                                <div class="option-info">
                                    <h4>Elite Group</h4>
                                    <p class="price">13,500 KSH</p>
                                    <span class="tickets">6 tickets</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-option" data-size="10" data-price="22500">
                            <div class="option-content">
                                <div class="option-icon">🎉</div>
                                <div class="option-info">
                                    <h4>Elite Party</h4>
                                    <p class="price">22,500 KSH</p>
                                    <span class="tickets">10 tickets</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
</body>
</html>
