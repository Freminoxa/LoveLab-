<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LoveLab</title>
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
        .action-btn {
            background: linear-gradient(135deg, #ff2e63, #764ba2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 46, 99, 0.3);
        }
        .quick-action-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s;
        }
        .quick-action-card:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 46, 99, 0.5);
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
                    <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.events.index') }}" class="nav-item">
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
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-white mb-2">Dashboard Overview</h2>
                <p class="text-white/70">Manage your events and bookings</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-white px-4 py-3 rounded-lg mb-6">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('admin.events.create') }}" class="quick-action-card group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus text-white text-xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-white/50 group-hover:text-pink-400 transition-colors"></i>
                    </div>
                    <h3 class="text-white font-semibold text-lg mb-1">Create Event</h3>
                    <p class="text-white/60 text-sm">Add a new event with packages</p>
                </a>

                <a href="{{ route('admin.bookings') }}" class="quick-action-card group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-list text-white text-xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-white/50 group-hover:text-blue-400 transition-colors"></i>
                    </div>
                    <h3 class="text-white font-semibold text-lg mb-1">View Bookings</h3>
                    <p class="text-white/60 text-sm">Manage all ticket bookings</p>
                </a>

                <a href="{{ route('admin.managers.create') }}" class="quick-action-card group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                        <i class="fas fa-arrow-right text-white/50 group-hover:text-green-400 transition-colors"></i>
                    </div>
                    <h3 class="text-white font-semibold text-lg mb-1">Add Manager</h3>
                    <p class="text-white/60 text-sm">Create new event manager</p>
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stat-card">
                    <div class="text-white/80 text-sm uppercase tracking-wide mb-2">Total Bookings</div>
                    <div class="text-3xl font-bold text-white">{{ $stats['total_bookings'] }}</div>
                    <div class="text-pink-400 mt-2">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="text-white/80 text-sm uppercase tracking-wide mb-2">Pending Payments</div>
                    <div class="text-3xl font-bold text-white">{{ $stats['pending_payments'] }}</div>
                    <div class="text-yellow-400 mt-2">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="text-white/80 text-sm uppercase tracking-wide mb-2">Confirmed Payments</div>
                    <div class="text-3xl font-bold text-white">{{ $stats['confirmed_payments'] }}</div>
                    <div class="text-green-400 mt-2">
                        <i class="fas fa-check-circle"></i>
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

            <!-- Recent Bookings -->
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-list mr-2"></i>Recent Bookings
                    </h3>
                    <a href="{{ route('admin.bookings') }}" class="action-btn">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                @if($bookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left text-white/70 font-medium py-3 px-4">ID</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Customer</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Event</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Amount</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Status</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings->take(10) as $booking)
                            <tr class="border-b border-white/5 hover:bg-white/5">
                                <td class="py-4 px-4 text-white">#{{ $booking->id }}</td>
                                <td class="py-4 px-4">
                                    <div class="text-white font-medium">{{ $booking->team_lead_name }}</div>
                                    <div class="text-white/60 text-sm">{{ $booking->team_lead_email }}</div>
                                </td>
                                <td class="py-4 px-4 text-white">{{ $booking->event->name ?? 'N/A' }}</td>
                                <td class="py-4 px-4 text-white font-semibold">KSH {{ number_format($booking->price) }}</td>
                                <td class="py-4 px-4">
                                    @if($booking->payment_status === 'confirmed')
                                        <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">
                                            Confirmed
                                        </span>
                                    @elseif($booking->payment_status === 'pending')
                                        <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-sm">
                                            Pending
                                        </span>
                                    @else
                                        <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-sm">
                                            Failed
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <a href="{{ route('admin.booking.show', $booking) }}" 
                                       class="text-pink-400 hover:text-pink-300">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 text-white/60">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p>No bookings found</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>