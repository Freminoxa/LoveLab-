<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tiko Iko On</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: white;
        }
        
        .admin-navbar {
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 900;
            color: #FF2E63;
        }
        
        .navbar-nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(255, 46, 99, 0.1);
            color: #FF2E63;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(45deg, #FF2E63, #08D9D6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: #FF2E63;
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #08D9D6;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 900;
            color: #FF2E63;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        .bookings-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #FF2E63, #08D9D6);
            color: white;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .bookings-table th,
        .bookings-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .bookings-table th {
            background: rgba(255, 255, 255, 0.05);
            font-weight: 600;
            color: #08D9D6;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
            border: 1px solid #fbbf24;
        }
        
        .status-confirmed {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border: 1px solid #10b981;
        }
        
        .status-failed {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid #ef4444;
        }
        
        .pagination {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }
        
        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid #10b981;
            color: #10b981;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="admin-navbar">
        <div class="navbar-content">
            <div class="navbar-brand">
                <i class="fas fa-shield-alt"></i> Admin Panel
            </div>
            <div class="navbar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-chart-bar"></i> Dashboard
                </a>
                <a href="{{ route('admin.bookings') }}" class="nav-link">
                    <i class="fas fa-calendar-alt"></i> All Bookings
                </a>
                <a href="{{ url('/') }}" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Site
                </a>
                <a href="{{ route('admin.logout') }}" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Admin Dashboard</h1>
            <p style="color: rgba(255, 255, 255, 0.7);">Manage your Tiko Iko On bookings and payments</p>
        </div>

        @if(session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number">{{ $stats['total_bookings'] }}</div>
                <div class="stat-label">Total Bookings</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ $stats['pending_payments'] }}</div>
                <div class="stat-label">Pending Payments</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">{{ $stats['confirmed_payments'] }}</div>
                <div class="stat-label">Confirmed Payments</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-number">KSH {{ number_format($stats['total_revenue']) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bookings-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-list"></i> Recent Bookings
                </h2>
                <a href="{{ route('admin.bookings') }}" class="btn btn-primary">
                    <i class="fas fa-eye"></i> View All Bookings
                </a>
            </div>

            @if($bookings->count() > 0)
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Team Lead</th>
                            <th>Plan</th>
                            <th>Group Size</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings->take(10) as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>
                                    <div>
                                        <strong>{{ $booking->team_lead_name }}</strong><br>
                                        <small style="color: rgba(255,255,255,0.6)">{{ $booking->team_lead_email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge" style="background: rgba(255,46,99,0.2); color: #FF2E63; border: 1px solid #FF2E63;">
                                        {{ $booking->plan_type }}
                                    </span>
                                </td>
                                <td>{{ $booking->group_size }} {{ $booking->group_size == 1 ? 'person' : 'people' }}</td>
                                <td>KSH {{ number_format($booking->price) }}</td>
                                <td>
                                    <span class="status-badge status-{{ $booking->payment_status }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $booking->created_at->format('M j, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.booking.show', $booking) }}" class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 3rem; color: rgba(255,255,255,0.6);">
                    <i class="fas fa-calendar-times" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <p>No bookings found</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
