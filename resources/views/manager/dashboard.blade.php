<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - LoveLab</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
        }
        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1.5rem;
            border-radius: 1rem;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-black/20 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-white">
                    <i class="fas fa-user-shield mr-2"></i>Manager Panel
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white/80">Welcome, {{ $manager->name }}</span>
                    <a href="{{ route('manager.logout') }}" class="text-white hover:text-pink-400">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-white px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card">
                <div class="text-white/80 text-sm uppercase tracking-wide mb-2">Total Events</div>
                <div class="text-3xl font-bold text-white">{{ $stats['total_events'] }}</div>
                <div class="text-pink-400 mt-2">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="text-white/80 text-sm uppercase tracking-wide mb-2">Total Bookings</div>
                <div class="text-3xl font-bold text-white">{{ $stats['total_bookings'] }}</div>
                <div class="text-blue-400 mt-2">
                    <i class="fas fa-ticket-alt"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="text-white/80 text-sm uppercase tracking-wide mb-2">Pending Confirmations</div>
                <div class="text-3xl font-bold text-white">{{ $stats['pending_confirmations'] }}</div>
                <div class="text-yellow-400 mt-2">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="text-white/80 text-sm uppercase tracking-wide mb-2">Total Revenue</div>
                <div class="text-3xl font-bold text-white">KSH {{ number_format($stats['total_revenue']) }}</div>
                <div class="text-green-400 mt-2">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <!-- Events List -->
        <div class="card p-6">
            <h2 class="text-2xl font-bold text-white mb-6">
                <i class="fas fa-calendar-check mr-2"></i>Your Events
            </h2>
            
            <div class="space-y-4">
                @forelse($events as $event)
                <div class="bg-white/5 border border-white/10 rounded-lg p-4 hover:border-pink-400/50 transition-all">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-white mb-2">{{ $event->name }}</h3>
                            <div class="text-white/70 space-y-1">
                                <p><i class="fas fa-calendar mr-2"></i>{{ $event->date->format('F d, Y - h:i A') }}</p>
                                <p><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}</p>
                            </div>
                            <div class="flex space-x-4 mt-3">
                                <span class="text-sm text-white/60">
                                    <i class="fas fa-ticket-alt mr-1"></i>
                                    {{ $event->bookings->where('payment_status', 'confirmed')->sum('group_size') }} tickets sold
                                </span>
                                <span class="text-sm text-green-400">
                                    <i class="fas fa-money-bill mr-1"></i>
                                    KSH {{ number_format($event->bookings->where('payment_status', 'confirmed')->sum('price')) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-2">
                            <a href="{{ route('manager.event.bookings', $event->id) }}" 
                               class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all text-center">
                                <i class="fas fa-eye mr-2"></i>View Bookings
                                @if($event->bookings->where('payment_status', 'pending')->count() > 0)
                                    <span class="ml-2 bg-yellow-500 text-xs px-2 py-1 rounded-full">
                                        {{ $event->bookings->where('payment_status', 'pending')->count() }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-white/60">
                    <i class="fas fa-calendar-times text-4xl mb-2"></i>
                    <p>No events assigned yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>