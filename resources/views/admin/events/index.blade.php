<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Admin Dashboard</title>
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
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(10px);
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
        
        .btn-primary {
            background: linear-gradient(135deg, #ff2e63, #764ba2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 46, 99, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 sidebar">
            <div class="p-6">
                <h2 class="text-xl font-bold text-white mb-8">Admin Panel</h2>
                
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-item">
                        <i class="fas fa-tachometer-alt"></i>
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
                        <i class="fas fa-user-tie"></i>
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
                    <p class="text-white/70">Manage all your events and their packages</p>
                </div>
                <a href="{{ route('admin.events.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>Create New Event
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-white px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            <!-- Events Grid -->
            @if($events && $events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
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
                                @if($event->manager)
                                <p class="text-white/70 text-sm">
                                    <i class="fas fa-user-tie mr-2"></i>{{ $event->manager->name }}
                                </p>
                                @endif
                                <p class="text-white/70 text-sm">
                                    <i class="fas fa-toggle-on mr-2"></i>
                                    <span class="px-2 py-1 rounded text-xs {{ 
                                        $event->status === 'published' ? 'bg-green-500/20 text-green-400' : 
                                        ($event->status === 'draft' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') 
                                    }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" 
                             alt="{{ $event->name }}" 
                             class="w-16 h-16 rounded-lg object-cover">
                        @endif
                    </div>

                    <!-- Event Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-white">
                                {{ $event->packages->count() }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Packages</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-yellow-400">
                                {{ $event->bookings->count() }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Bookings</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-400">
                                KSH {{ number_format($event->bookings->where('payment_status', 'confirmed')->sum('price')) }}
                            </div>
                            <div class="text-xs text-white/60 mt-1">Revenue</div>
                        </div>
                    </div>

                    <!-- Packages Preview -->
                    @if($event->packages->count() > 0)
                    <div class="mb-4">
                        <h4 class="text-white font-semibold text-sm mb-2">Packages:</h4>
                        <div class="space-y-1">
                            @foreach($event->packages->take(3) as $package)
                            <div class="flex justify-between text-sm">
                                <span class="text-white/70">{{ $package->name }}</span>
                                <span class="text-green-400">KSH {{ number_format($package->price) }}</span>
                            </div>
                            @endforeach
                            @if($event->packages->count() > 3)
                            <div class="text-xs text-white/50">+{{ $event->packages->count() - 3 }} more...</div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Event Actions -->
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('admin.events.show', $event) }}" class="btn-secondary justify-center">
                            <i class="fas fa-eye"></i>View Details
                        </a>
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn-secondary justify-center">
                            <i class="fas fa-edit"></i>Edit
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <div class="text-white/60 mb-4">
                    <i class="fas fa-calendar-plus text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">No Events Yet</h3>
                    <p>Create your first event to get started</p>
                </div>
                <a href="{{ route('admin.events.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>Create Your First Event
                </a>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
