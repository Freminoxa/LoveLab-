<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '💜 LoveLab - Premium Event Experience')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('head')
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-900 via-pink-800 to-indigo-900 overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-black/20 backdrop-blur-md border-b border-white/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2 group">
                    <div class="text-2xl font-bold bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent group-hover:scale-105 transition-transform duration-300">
                        💜 LoveLab
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                    <a href="/#pricing" class="nav-link">
                        <i class="fas fa-tags mr-2"></i>Pricing
                    </a>
                    <a href="/#contact" class="nav-link">
                        <i class="fas fa-envelope mr-2"></i>Contact
                    </a>
                    @yield('nav-actions')
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-white hover:text-pink-400 transition-colors duration-300">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden mobile-menu bg-black/90 backdrop-blur-xl border-t border-white/10">
            <div class="px-4 py-6 space-y-4">
                <a href="/" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fas fa-home mr-3"></i>Home
                </a>
                <a href="/#pricing" class="mobile-nav-link">
                    <i class="fas fa-tags mr-3"></i>Pricing
                </a>
                <a href="/#contact" class="mobile-nav-link">
                    <i class="fas fa-envelope mr-3"></i>Contact
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-black/30 backdrop-blur-md border-t border-white/10 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Logo & Description -->
                <div class="md:col-span-2">
                    <div class="text-2xl font-bold bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent mb-4">
                        💜 LoveLab
                    </div>
                    <p class="text-white/60 mb-6 max-w-md">
                        Creating unforgettable love experiences for the Gen Z generation. Join Kenya's most exclusive events.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="/" class="footer-link">Home</a>
                        <a href="/#pricing" class="footer-link">Pricing</a>
                        <a href="/#about" class="footer-link">About Us</a>
                        <a href="/#contact" class="footer-link">Contact</a>
                    </div>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Support</h3>
                    <div class="space-y-2">
                        <a href="#" class="footer-link">
                            <i class="fas fa-phone mr-2"></i>+254 700 000 000
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fab fa-whatsapp mr-2"></i>WhatsApp Support
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-envelope mr-2"></i>hello@lovelab.ke
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 mt-8 pt-8 text-center">
                <p class="text-white/60">
                    © {{ date('Y') }} LoveLab. All rights reserved. Made with 💜 for Gen Z
                </p>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
