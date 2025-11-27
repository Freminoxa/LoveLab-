<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Tiko Iko On</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        
        .event-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 46, 99, 0.3);
        }
        
        .btn-bookings {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 8px 16px;
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
        
        .search-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: white;
            placeholder-color: rgba(255, 255, 255, 0.6);
            width: 100%;
        }
        
        .search-input:focus {
            outline: none;
            border-color: rgba(255, 46, 99, 0.5);
            box-shadow: 0 0 0 3px rgba(255, 46, 99, 0.2);
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .filter-badge {
            background: rgba(255, 46, 99, 0.2);
            color: #ff2e63;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
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
                    <form action="{{ route('manager.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-pink-400">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
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

        <!-- Search and Filter Section -->
        <div class="search-container">
            <h3 class="text-white text-lg font-semibold mb-4">
                <i class="fas fa-search mr-2"></i>Search Events
            </h3>
            <form method="GET" action="{{ route('manager.dashboard') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by event name or location..." 
                               class="search-input">
                    </div>
                    <div>
                        <select name="status" class="search-input">
                            <option value="">All Statuses</option>
                            <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Past Events</option>
                            <option value="today" {{ request('status') == 'today' ? 'selected' : '' }}>Today</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-bookings flex-1 justify-center">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('manager.dashboard') }}" class="btn-bookings">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
            
            @if(request()->hasAny(['search', 'status']))
            <div class="mt-4 flex items-center gap-2">
                <span class="text-white/70 text-sm">Active filters:</span>
                @if(request('search'))
                    <span class="filter-badge">Search: "{{ request('search') }}"</span>
                @endif
                @if(request('status'))
                    <span class="filter-badge">Status: {{ ucfirst(request('status')) }}</span>
                @endif
            </div>
            @endif
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="event-card p-6 text-center">
                <div class="text-3xl font-bold text-blue-400 mb-2">{{ $stats['total_events'] }}</div>
                <div class="text-white/80">Total Events</div>
            </div>
            <div class="event-card p-6 text-center">
                <div class="text-3xl font-bold text-green-400 mb-2">{{ $stats['total_bookings'] }}</div>
                <div class="text-white/80">Total Bookings</div>
            </div>
            <div class="event-card p-6 text-center">
                <div class="text-3xl font-bold text-yellow-400 mb-2">{{ $stats['pending_confirmations'] }}</div>
                <div class="text-white/80">Pending Confirmations</div>
            </div>
            <div class="event-card p-6 text-center">
                <div class="text-3xl font-bold text-purple-400 mb-2">{{ $stats['total_attended'] }}</div>
                <div class="text-white/80">Total Attended</div>
            </div>
            <div class="event-card p-6 text-center">
                <div class="text-3xl font-bold text-pink-400 mb-2">KSH {{ number_format($stats['total_revenue']) }}</div>
                <div class="text-white/80">Total Revenue</div>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                <i class="fas fa-calendar-alt mr-3"></i>
                Your Events 
                @if($events->count() > 0)
                    <span class="text-white/60 text-lg ml-2">({{ $events->count() }} {{ $events->count() == 1 ? 'event' : 'events' }})</span>
                @endif
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                <div class="event-card p-6">
                    <!-- Event Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $event->name }}</h3>
                            <div class="space-y-1">
                                <p class="text-white/70 text-sm">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $event->date->format('M d, Y - h:i A') }}
                                </p>
                                <p class="text-white/70 text-sm">
                                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}
                                </p>
                                @if($event->till_number)
                                <p class="text-white/70 text-sm">
                                    <i class="fas fa-credit-card mr-2"></i>Till: {{ $event->till_number }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" 
                             alt="{{ $event->name }}" 
                             class="w-16 h-16 rounded-lg object-cover">
                        @endif
                    </div>

                    <!-- Event Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-white">
                                {{ $event->bookings->count() }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Total Bookings</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-yellow-400">
                                {{ $event->bookings->where('payment_status', 'pending')->count() }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Pending</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-400">
                                {{ $event->bookings->where('payment_status', 'confirmed')->count() }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Confirmed</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-purple-400">
                                {{ $event->bookings->where('has_attended', true)->count() }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Attended</div>
                        </div>
                    </div>

                    <!-- Event Actions -->
                    <div class="grid grid-cols-1 gap-2">
                        <a href="{{ route('manager.event.bookings', $event) }}" class="btn-bookings justify-center">
                            <i class="fas fa-list-alt"></i> View Bookings
                        </a>
                        <a href="{{ route('manager.scanner', $event) }}" class="btn-bookings justify-center">
                            <i class="fas fa-qrcode"></i> Scan Tickets
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-white/60">
                    <i class="fas fa-calendar-times text-5xl mb-4"></i>
                    @if(request()->hasAny(['search', 'status']))
                        <p class="text-lg">No events found matching your search criteria</p>
                        <p class="text-sm mt-2">Try adjusting your filters or search terms</p>
                        <a href="{{ route('manager.dashboard') }}" class="btn-bookings mt-4 inline-flex">
                            <i class="fas fa-arrow-left mr-2"></i>View All Events
                        </a>
                    @else
                        <p class="text-lg">No events assigned yet</p>
                        <p class="text-sm mt-2">Contact your administrator to get events assigned</p>
                    @endif
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