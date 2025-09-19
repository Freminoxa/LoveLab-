<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Management - Tiko Iko On Admin</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        .nav-item {
            color: rgba(255, 255, 255, 0.7);
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .nav-item:hover, .nav-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: #ff2e63;
        }
        .event-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            transition: all 0.3s;
        }
        .event-card:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 46, 99, 0.5);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <div class="sidebar w-64 flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-white mb-8">
                    <i class="fas fa-shield-alt mr-2"></i>Admin Panel
                </h1>
                
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-item">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.events.index') }}" class="nav-item active">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Events</span>
                    </a>
                    
                    <a href="{{ route('admin.bookings') }}" class="nav-item">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Bookings</span>
                    </a>
                    
                    <a href="{{ route('admin.managers.create') }}" class="nav-item">
                        <i class="fas fa-user-shield"></i>
                        <span>Managers</span>
                    </a>
                    
                    <div class="border-t border-white/10 my-4"></div>
                    
                    <a href="{{ url('/') }}" target="_blank" class="nav-item">
                        <i class="fas fa-globe"></i>
                        <span>View Website</span>
                    </a>
                    
                    <a href="{{ route('admin.logout') }}" class="nav-item">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">Events Management</h2>
                    <p class="text-white/70">Manage all your events and ticket packages</p>
                </div>
                <a href="{{ route('admin.events.create') }}" 
                   class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-pink-600 hover:to-purple-700 transition-all inline-flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i> Create New Event
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-white px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                <div class="event-card p-6">
                    <!-- Event Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $event->name }}</h3>
                            <div class="space-y-1">
                                <p class="text-white/70 text-sm">
                                    <i class="fas fa-calendar mr-2"></i>{{ $event->date->format('M d, Y - h:i A') }}
                                </p>
                                <p class="text-white/70 text-sm">
                                    <i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}
                                </p>
                            </div>
                        </div>
                        @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" 
                             alt="{{ $event->name }}" 
                             class="w-20 h-20 rounded-lg object-cover ml-4">
                        @endif
                    </div>

                    <!-- Event Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-4 pb-4 border-b border-white/10">
                        <div>
                            <p class="text-white/60 text-xs uppercase tracking-wide mb-1">Tickets Sold</p>
                            <p class="text-white font-bold text-lg">
                                {{ $event->bookings->where('payment_status', 'confirmed')->sum('group_size') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-white/60 text-xs uppercase tracking-wide mb-1">Revenue</p>
                            <p class="text-green-400 font-bold text-lg">
                                KSH {{ number_format($event->bookings->where('payment_status', 'confirmed')->sum('price')) }}
                            </p>
                        </div>
                    </div>

                    <!-- Manager Info -->
                    <div class="mb-4">
                        <p class="text-white/60 text-xs uppercase tracking-wide mb-1">Manager</p>
                        <p class="text-white">
                            {{ $event->manager ? $event->manager->name : 'Not assigned' }}
                        </p>
                    </div>

                    <!-- Package Count -->
                    <div class="mb-4">
                        <p class="text-white/60 text-xs uppercase tracking-wide mb-1">Packages</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($event->packages as $package)
                            <span class="bg-white/10 text-white text-xs px-2 py-1 rounded">
                                {{ $package->name }} - KSH {{ number_format($package->price) }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('admin.events.show', $event) }}" 
                           class="bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 px-3 py-2 rounded text-center text-sm font-medium transition-all">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                        <a href="{{ route('admin.events.edit', $event) }}" 
                           class="bg-yellow-500/20 text-yellow-400 hover:bg-yellow-500/30 px-3 py-2 rounded text-center text-sm font-medium transition-all">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                    </div>

                    <!-- Delete Button (Separate) -->
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure? This will delete all packages and bookings!')"
                                class="w-full bg-red-500/20 text-red-400 hover:bg-red-500/30 px-3 py-2 rounded text-sm font-medium transition-all">
                            <i class="fas fa-trash mr-1"></i> Delete Event
                        </button>
                    </form>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white/5 border border-white/10 rounded-xl p-12 text-center">
                        <i class="fas fa-calendar-times text-6xl text-white/20 mb-4"></i>
                        <h3 class="text-white text-xl font-semibold mb-2">No Events Yet</h3>
                        <p class="text-white/60 mb-6">Create your first event to get started</p>
                        <a href="{{ route('admin.events.create') }}" 
                           class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-pink-600 hover:to-purple-700 transition-all inline-flex items-center gap-2">
                            <i class="fas fa-plus-circle"></i> Create New Event
                        </a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>