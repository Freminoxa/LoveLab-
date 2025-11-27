<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💜 Payment - Tiko Iko On</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [data-animate-error] {
            animation: fadeInDown 0.4s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</head>

<body class="min-h-screen bg-gradient-to-br from-purple-900 via-pink-800 to-indigo-900">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-black/20 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center space-x-2">
                    <div class="text-2xl font-bold bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">
                        💜 Tiko Iko On
                    </div>
                </a>
                <div class="flex items-center space-x-4">
                    <div class="text-white/60 text-sm">Secure Payment</div>
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Payment Section -->
    <section class="pt-24 pb-16 min-h-screen flex items-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4 mb-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="ml-2 text-white/80 text-sm">Booking Details</span>
                    </div>
                    <div class="w-16 h-0.5 bg-gradient-to-r from-green-500 to-purple-400"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-sm font-semibold animate-pulse">
                            2
                        </div>
                        <span class="ml-2 text-white font-medium text-sm">Payment</span>
                    </div>
                    <div class="w-16 h-0.5 bg-white/20"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white/60 text-sm font-semibold">
                            3
                        </div>
                        <span class="ml-2 text-white/60 text-sm">Confirmation</span>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Payment Instructions -->
                <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8">
                    <div class="text-center mb-8">
                        <div class="text-5xl mb-4">📱</div>
                        <h2 class="text-3xl font-bold text-white mb-2">Pay with M-PESA</h2>
                        <p class="text-white/60">Fast, secure & convenient mobile payment</p>
                    </div>

                    <!-- Amount Display -->
                    <div class="bg-gradient-to-r from-purple-600/20 to-pink-600/20 rounded-2xl p-6 mb-8 border border-purple-400/20">
                        <div class="text-center">
                            <div class="text-white/60 text-sm mb-2">Amount to Pay</div>
                            <div class="text-4xl font-bold text-white mb-2">
                                KSH {{ number_format($package->price, 2) }}
                            </div>
                            <div class="text-purple-300 text-sm">
                                {{ $booking["plan_type"] }} • {{ $package->group_size }} {{ $package->group_size == 1 ? 'ticket' : 'tickets' }}
                            </div>
                        </div>
                    </div>

                    <!-- Till Number -->
                    <div class="bg-white/5 rounded-2xl p-6 mb-8 border border-white/10">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-white/60 text-sm mb-1">M-PESA Till Number</div>
                                <div class="text-2xl font-bold text-white">{{ $event->till_number }}</div>
                            </div>
                            <button onclick="copyTillNumber()" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-xl transition-colors duration-300 flex items-center space-x-2">
                                <i class="fas fa-copy"></i>
                                <span>Copy</span>
                            </button>
                        </div>
                    </div>

                    <!-- Step-by-step Instructions -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <span class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-sm mr-3">
                                <i class="fas fa-list"></i>
                            </span>
                            Payment Steps
                        </h3>

                        <div class="space-y-3">
                            <div class="flex items-start space-x-3 p-3 bg-white/5 rounded-xl border border-white/10">
                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mt-0.5">1</div>
                                <div class="text-white/80">Open M-PESA on your phone</div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-white/5 rounded-xl border border-white/10">
                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mt-0.5">2</div>
                                <div class="text-white/80">Select "Lipa na M-PESA"</div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-white/5 rounded-xl border border-white/10">
                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mt-0.5">3</div>
                                <div class="text-white/80">Choose "Buy Goods and Services"</div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-white/5 rounded-xl border border-white/10">
                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mt-0.5">4</div>
                                <div class="text-white/80">Enter Till Number: <span id="till_number" class="font-semibold text-purple-300">{{ $event->till_number }}</span></div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-white/5 rounded-xl border border-white/10">
                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mt-0.5">5</div>
                                <div class="text-white/80">Enter Amount: <span class="font-semibold text-purple-300">KSH {{ number_format($package->price, 2) }}</span></div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-white/5 rounded-xl border border-white/10">
                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold mt-0.5">6</div>
                                <div class="text-white/80">Enter your M-PESA PIN and confirm</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Form -->
                <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8">
                    <div class="text-center mb-8">
                        <div class="text-5xl mb-4">✨</div>
                        <h2 class="text-3xl font-bold text-white mb-2">Confirm Payment</h2>
                        <p class="text-white/60">Enter your M-PESA confirmation code below</p>
                    </div>

                    <!-- Booking Summary -->
                    <div class="bg-gradient-to-r from-purple-600/10 to-pink-600/10 rounded-2xl p-6 mb-8 border border-purple-400/20">
                        <h3 class="text-lg font-semibold text-white mb-4">Booking Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-white/60">Plan Type</span>
                                <span class="text-white font-medium">{{ $booking["plan_type"] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-white/60">Group Size</span>
                                <span class="text-white font-medium">{{ $package->group_size }} {{ $package->group_size == 1 ? 'person' : 'people' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-white/60">Team Lead</span>
                                <span class="text-white font-medium">{{ $booking["team_lead_name"] }}</span>
                            </div>
                            <div class="border-t border-white/10 pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-white font-semibold">Total Amount</span>
                                    <span class="text-2xl font-bold text-purple-300">KSH {{ number_format($package->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <!-- Error Output -->
                    @if ($errors->any())
                    <div class="mb-6 bg-red-500/10 border border-red-400/30 rounded-xl p-4 text-red-300">
                        <div class="flex items-center space-x-2 mb-2">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                            <span class="font-semibold">There was a problem with your submission:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm text-red-200 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('confirm.payment') }}" method="POST" id="payment-form" class="space-y-6">
                        @csrf

                        <div>
                            <label for="mpesa_code" class="block text-white font-medium mb-3">
                                <i class="fas fa-mobile-alt mr-2 text-purple-400"></i>
                                M-PESA Confirmation Code
                            </label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="mpesa_code"
                                    name="mpesa_code"
                                    required
                                    maxlength="10"
                                    class="w-full px-4 py-4 bg-white/5 border border-white/20 rounded-xl text-white placeholder-white/50 focus:border-purple-400 focus:ring-2 focus:ring-purple-400/20 focus:outline-none transition-all duration-300 text-lg tracking-wider"
                                    placeholder="e.g., QWE1234XYZ"
                                    oninput="formatMpesaCode(this)">
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-shield-alt text-green-400"></i>
                                </div>
                            </div>
                            <div class="text-white/40 text-sm mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                You'll receive this code via SMS after payment
                            </div>
                        </div>

                        <button
                            type="submit"
                            id="confirm-btn"
                            class="w-full bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white py-4 px-6 rounded-xl font-semibold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-2xl flex items-center justify-center space-x-3">
                            <i class="fas fa-check-circle"></i>
                            <span>Confirm Booking</span>
                        </button>

                        <div class="text-center">
                            <p class="text-white/60 text-sm">
                                <i class="fas fa-lock mr-2"></i>
                                Your payment is secure and encrypted
                            </p>
                        </div>
                    </form>

                    <!-- Help Section -->
                    <div class="mt-8 pt-6 border-t border-white/10">
                        <div class="text-center">
                            <p class="text-white/60 text-sm mb-4">Need help with payment?</p>
                            <div class="flex justify-center space-x-4">
                                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm flex items-center space-x-2 transition-colors">
                                    <i class="fas fa-phone"></i>
                                    <span>Call Support</span>
                                </a>
                                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm flex items-center space-x-2 transition-colors">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-20 right-4 z-50 transform translate-x-full transition-transform duration-500">
        <div class="bg-gradient-to-r from-green-400 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl max-w-md">
            <div class="flex items-center space-x-3">
                <i class="fas fa-copy text-xl"></i>
                <span>Till number copied to clipboard!</span>
            </div>
        </div>
    </div>

    <script>
        // Copy till number functionality
        function copyTillNumber() {
            const span = document.getElementById('till_number');
            const till_number = span.textContent;
            navigator.clipboard.writeText(till_number).then(function() {
                showToast();
            });
        }

        // Show toast notification
        function showToast() {
            const toast = document.getElementById('toast');
            toast.style.transform = 'translateX(0)';
            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
            }, 3000);
        }

        // Format M-PESA code input
        function formatMpesaCode(input) {
            input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        }

        // Form submission with loading state
        document.getElementById('payment-form').addEventListener('submit', function() {
            const btn = document.getElementById('confirm-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            btn.disabled = true;
        });

        // Auto-focus on M-PESA code input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('mpesa_code').focus();
        });
    </script>

    @include('partials.footer')
</body>

</html>
