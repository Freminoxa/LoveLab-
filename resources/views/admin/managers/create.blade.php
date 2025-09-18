<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Manager - Tiko Iko On Admin</title>
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
                    
                    <a href="{{ route('admin.events.index') }}" class="nav-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Events</span>
                    </a>
                    
                    <a href="{{ route('admin.bookings') }}" class="nav-item">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Bookings</span>
                    </a>
                    
                    <a href="{{ route('admin.managers.create') }}" class="nav-item active">
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
            <div class="max-w-2xl mx-auto">
                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Create Event Manager</h2>
                    <p class="text-white/70">Add a new manager to oversee events</p>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/50 text-white px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 text-white px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('admin.managers.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20">
                        <h3 class="text-xl font-semibold text-white mb-6">Manager Details</h3>
                        
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-white/80 font-medium mb-2">
                                    <i class="fas fa-user mr-2"></i>Full Name *
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:border-pink-400 focus:ring-2 focus:ring-pink-400/50 outline-none transition-all"
                                       placeholder="Enter manager's full name">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-white/80 font-medium mb-2">
                                    <i class="fas fa-envelope mr-2"></i>Email Address *
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:border-pink-400 focus:ring-2 focus:ring-pink-400/50 outline-none transition-all"
                                       placeholder="manager@tikoikoon.com">
                                <p class="text-white/60 text-sm mt-1">This will be used for login</p>
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-white/80 font-medium mb-2">
                                    <i class="fas fa-lock mr-2"></i>Password *
                                </label>
                                <input type="password" name="password" required minlength="6"
                                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:border-pink-400 focus:ring-2 focus:ring-pink-400/50 outline-none transition-all"
                                       placeholder="Minimum 6 characters">
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label class="block text-white/80 font-medium mb-2">
                                    <i class="fas fa-lock mr-2"></i>Confirm Password *
                                </label>
                                <input type="password" name="password_confirmation" required minlength="6"
                                       class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:border-pink-400 focus:ring-2 focus:ring-pink-400/50 outline-none transition-all"
                                       placeholder="Re-enter password">
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-500/20 border border-blue-500/50 text-white px-4 py-3 rounded-lg">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-400 mt-1"></i>
                            <div>
                                <p class="font-medium mb-1">Manager Capabilities:</p>
                                <ul class="text-sm text-white/80 space-y-1">
                                    <li>• View and manage assigned events</li>
                                    <li>• Confirm or reject booking payments</li>
                                    <li>• Track event revenue and statistics</li>
                                    <li>• Access manager dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <button type="submit"
                                class="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all">
                            <i class="fas fa-user-plus mr-2"></i>Create Manager
                        </button>
                        <a href="{{ route('admin.events.create') }}"
                           class="flex-1 bg-white/10 text-white font-semibold py-3 px-6 rounded-lg hover:bg-white/20 transition-all text-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>

                    <!-- Manager Login Info -->
                    <div class="bg-white/5 border border-white/10 rounded-lg p-4">
                        <p class="text-white/70 text-sm">
                            <i class="fas fa-link mr-2"></i>
                            After creation, the manager can login at: 
                                <a href="{{ url('/manager/login') }}" target="_blank" class="text-pink-400 hover:text-pink-300">
                                    {{ url('/manager/login') }}
                                </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>