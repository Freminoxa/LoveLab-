<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💜 LoveLab - Premium Event Experience</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-900 via-pink-800 to-indigo-900 overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-black/20 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="text-2xl font-bold bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">
                        💜 LoveLab
                    </div>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-white/80 hover:text-white transition-colors duration-300">Home</a>
                    <a href="#pricing" class="text-white/80 hover:text-white transition-colors duration-300">Pricing</a>
                    <a href="#contact" class="text-white/80 hover:text-white transition-colors duration-300">Contact</a>
                </div>
                <button id="mobile-menu-btn" class="md:hidden text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Success Message -->
    @if (session('success'))
        <div id="success-toast" class="fixed top-20 right-4 z-50 transform translate-x-full transition-transform duration-500">
            <div class="bg-gradient-to-r from-green-400 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl max-w-md">
                <div class="flex items-center space-x-3">
                    <div class="text-2xl animate-bounce">🎉</div>
                    <div>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="hideToast()" class="text-white/80 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section id="home" class="pt-24 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 to-pink-600/20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight">
                    Experience The
                    <span class="bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent animate-pulse">
                        Ultimate
                    </span>
                    <br>Love Event 💜
                </h1>
                <p class="text-xl md:text-2xl text-white/80 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Join Kenya's most exclusive love experience. Connect, vibe, and create unforgettable memories.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="#pricing" class="group bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        Book Your Spot <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <button class="text-white/80 hover:text-white font-medium text-lg flex items-center space-x-2 transition-colors">
                        <i class="fas fa-play-circle text-2xl"></i>
                        <span>Watch Trailer</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Floating elements -->
        <div class="absolute top-1/4 left-10 text-6xl animate-float">💕</div>
        <div class="absolute top-1/3 right-20 text-4xl animate-float-delayed">✨</div>
        <div class="absolute bottom-20 left-1/4 text-5xl animate-float">🌹</div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Choose Your <span class="bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">Experience</span>
                </h2>
                <p class="text-xl text-white/70 max-w-2xl mx-auto">
                    From intimate moments to group celebrations - we've got the perfect package for your vibe
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- IP Plan -->
                <div class="pricing-card bg-gradient-to-br from-slate-800/50 to-slate-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl group">
                    <div class="text-center mb-8">
                        <div class="text-4xl mb-4">🌟</div>
                        <h3 class="text-2xl font-bold text-white mb-2">IP Experience</h3>
                        <p class="text-white/60">Perfect for first-timers</p>
                    </div>
                    
                    <div class="space-y-4">
                        <button onclick="selectPlan('IP', 1, 500)" class="pricing-option w-full bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-6 text-left transition-all duration-300 hover:border-pink-400/50 group/option">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Solo Adventure</h4>
                                    <p class="text-white/60">1 ticket</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-pink-400">KSH 500</div>
                                    <i class="fas fa-arrow-right text-white/40 group-hover/option:text-pink-400 group-hover/option:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </button>

                        <button onclick="selectPlan('IP', 2, 800)" class="pricing-option w-full bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-6 text-left transition-all duration-300 hover:border-pink-400/50 group/option">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Couple's Escape</h4>
                                    <p class="text-white/60">2 tickets</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-pink-400">KSH 800</div>
                                    <i class="fas fa-arrow-right text-white/40 group-hover/option:text-pink-400 group-hover/option:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </button>

                        <button onclick="selectPlan('IP', 6, 1500)" class="pricing-option w-full bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-6 text-left transition-all duration-300 hover:border-pink-400/50 group/option">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Squad Goals</h4>
                                    <p class="text-white/60">6 tickets</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-pink-400">KSH 1,500</div>
                                    <i class="fas fa-arrow-right text-white/40 group-hover/option:text-pink-400 group-hover/option:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- VIP Plan -->
                <div class="pricing-card bg-gradient-to-br from-purple-800/50 to-purple-900/50 backdrop-blur-xl border-2 border-purple-400/50 rounded-3xl p-8 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl shadow-purple-500/20 group relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-2 rounded-full text-sm font-semibold">
                        MOST POPULAR
                    </div>
                    
                    <div class="text-center mb-8">
                        <div class="text-4xl mb-4">👑</div>
                        <h3 class="text-2xl font-bold text-white mb-2">VIP Experience</h3>
                        <p class="text-white/60">Premium vibes only</p>
                    </div>
                    
                    <div class="space-y-4">
                        <button onclick="selectPlan('VIP', 1, 1000)" class="pricing-option w-full bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-6 text-left transition-all duration-300 hover:border-purple-400/50 group/option">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Solo VIP</h4>
                                    <p class="text-white/60">1 premium ticket</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-purple-400">KSH 1,000</div>
                                    <i class="fas fa-arrow-right text-white/40 group-hover/option:text-purple-400 group-hover/option:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </button>

                        <button onclick="selectPlan('VIP', 2, 1800)" class="pricing-option w-full bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-6 text-left transition-all duration-300 hover:border-purple-400/50 group/option">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Premium Duo</h4>
                                    <p class="text-white/60">2 premium tickets</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-purple-400">KSH 1,800</div>
                                    <i class="fas fa-arrow-right text-white/40 group-hover/option:text-purple-400 group-hover/option:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </button>

                        <button onclick="selectPlan('VIP', 6, 4500)" class="pricing-option w-full bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-6 text-left transition-all duration-300 hover:border-purple-400/50 group/option">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">VIP Squad</h4>
                                    <p class="text-white/60">6 premium tickets</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-purple-400">KSH 4,500</div>
                                    <i class="fas fa-arrow-right text-white/40 group-hover/option:text-purple-400 group-hover/option:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- VVIP Plan -->
                <div class="pricing-card bg-gradient-to-br from-amber-800/50 to-yellow-900/50 backdrop-blur-xl border border-amber-400/30 rounded-3xl p-8 transform hover:scale-105 transition-all duration-300 hover:shadow-2xl shadow-amber-500/20 group">
                    <div class="text-center mb-8">
                        <div class="text-4xl mb-4">💎</div>
                        <h3 class="text-2xl font-bold text-white mb-2">VVIP Experience</h3>
                        <p class="text-white/60">Ultimate luxury</p>
                    </div>
                    
                    <div class="space-y-4">
                        <button onclick="selectPlan('VVIP', 1, 2500)" class="pricing-option w-full bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-6 text-left transition-all duration-300 hover:border-amber-400/50 group/option">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Diamond Solo</h4>
                                    <p class="text-white/60">1 luxury ticket</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-amber-400">KSH 2,500</div>
                                    <i class="fas fa-arrow-right text-white/40 group-hover/option:text-amber-400 group-hover/option:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </button>

                        <button onclick="selectPlan('VVIP', 2, 4800)" class="pricing-option w-full bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-6 text-left transition-all duration-300 hover:border-amber-400/50 group/option">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Luxury Pair</h4>
                                    <p class="text-white/60">2 luxury tickets</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-amber-400">KSH 4,800</div>
                                    <i class="fas fa-arrow-right text-white/40 group-hover/option:text-amber-400 group-hover/option:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </button>

                        <button onclick="selectPlan('VVIP', 6, 13500)" class="pricing-option w-full bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl p-6 text-left transition-all duration-300 hover:border-amber-400/50 group/option">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Elite Squad</h4>
                                    <p class="text-white/60">6 luxury tickets</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-amber-400">KSH 13,500</div>
                                    <i class="fas fa-arrow-right text-white/40 group-hover/option:text-amber-400 group-hover/option:translate-x-1 transition-all"></i>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Modal -->
    <div id="booking-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-8 max-w-2xl w-full border border-white/10 transform scale-95 transition-transform duration-300" id="modal-content">
                <!-- Modal content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black/30 backdrop-blur-md border-t border-white/10 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="text-2xl font-bold bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent mb-4">
                💜 LoveLab
            </div>
            <p class="text-white/60">Creating unforgettable love experiences • Follow us for updates</p>
            <div class="flex justify-center space-x-6 mt-4">
                <a href="#" class="text-white/60 hover:text-pink-400 transition-colors">
                    <i class="fab fa-instagram text-2xl"></i>
                </a>
                <a href="#" class="text-white/60 hover:text-pink-400 transition-colors">
                    <i class="fab fa-tiktok text-2xl"></i>
                </a>
                <a href="#" class="text-white/60 hover:text-pink-400 transition-colors">
                    <i class="fab fa-twitter text-2xl"></i>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>