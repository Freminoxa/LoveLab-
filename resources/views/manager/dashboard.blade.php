<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Tiko Iko On</title>
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
        
        /* Scanner Button Styles */
        .btn-scanner {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-scanner:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #5568d3, #6a3e9a);
        }
        
        .btn-bookings {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-bookings:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .event-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        
        .verified-badge {
            background: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .pending-badge {
            background: #f59e0b;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
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
                    <div class="flex flex-col lg:flex-row justify-between items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-white mb-2">{{ $event->name }}</h3>
                            <div class="text-white/70 space-y-1">
                                <p><i class="fas fa-calendar mr-2"></i>{{ $event->date->format('F d, Y - h:i A') }}</p>
                                <p><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}</p>
                            </div>
                            
                            <!-- Event Statistics -->
                            <div class="flex flex-wrap gap-4 mt-3">
                                <span class="text-sm text-white/60">
                                    <i class="fas fa-ticket-alt mr-1"></i>
                                    {{ $event->bookings->where('payment_status', 'confirmed')->sum('group_size') }} tickets sold
                                </span>
                                <span class="text-sm text-green-400">
                                    <i class="fas fa-money-bill mr-1"></i>
                                    KSH {{ number_format($event->bookings->where('payment_status', 'confirmed')->sum('price')) }}
                                </span>
                                
                                @php
                                    $verifiedCount = $event->bookings->where('is_verified', true)->count();
                                    $pendingCount = $event->bookings->where('payment_status', 'pending')->count();
                                @endphp
                                
                                @if($verifiedCount > 0)
                                <span class="verified-badge">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    {{ $verifiedCount }} Verified
                                </span>
                                @endif
                                
                                @if($pendingCount > 0)
                                <span class="pending-badge">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $pendingCount }} Pending
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="event-actions">
                            <a href="{{ route('manager.event.bookings', $event->id) }}" 
                               class="btn-bookings">
                                <i class="fas fa-eye"></i>
                                View Bookings
                                @if($event->bookings->where('payment_status', 'pending')->count() > 0)
                                    <span class="ml-1 bg-yellow-500 text-xs px-2 py-1 rounded-full">
                                        {{ $event->bookings->where('payment_status', 'pending')->count() }}
                                    </span>
                                @endif
                            </a>
                            
                            <a href="{{ route('manager.scanner', $event->id) }}" 
                               class="btn-scanner">
                                <i class="fas fa-qrcode"></i>
                                Scan Tickets
                            </a>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-white/10">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">
                                {{ $event->bookings->count() }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Total Bookings</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-400">
                                {{ $event->bookings->where('payment_status', 'pending')->count() }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Pending</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-400">
                                {{ $event->bookings->where('is_verified', true)->count() }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Verified</div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-white/60">
                    <i class="fas fa-calendar-times text-5xl mb-4"></i>
                    <p class="text-lg">No events assigned yet</p>
                    <p class="text-sm mt-2">Contact your administrator to get events assigned</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Access Footer -->
    <div class="fixed bottom-0 left-0 right-0 bg-black/30 backdrop-blur-md border-t border-white/10 py-3">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center text-white/60 text-sm">
                <span>
                    <i class="fas fa-info-circle mr-2"></i>
                    Click "Scan Tickets" to verify attendees at the entrance
                </span>
                <span>
                    {{ $stats['total_events'] }} Events | {{ $stats['total_bookings'] }} Bookings
                </span>
            </div>
        </div>
    </div>
</body>
</html>