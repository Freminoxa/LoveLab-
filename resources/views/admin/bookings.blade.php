<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Bookings - Admin</title>
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
            max-width: 1400px;
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
        
        .bookings-table-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            overflow-x: auto;
        }
        
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
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
            position: sticky;
            top: 0;
        }
        
        .bookings-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
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
            font-size: 0.9rem;
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
        
        .pagination {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }
        
        .pagination .page-link {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .pagination .page-link:hover,
        .pagination .page-item.active .page-link {
            background: #FF2E63;
            border-color: #FF2E63;
            color: white;
        }
        
        .filter-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }
        
        .filter-group label {
            display: block;
            color: #08D9D6;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            font-size: 0.9rem;
        }
        
        .filter-group select option {
            background: #1e293b;
            color: white;
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
                <a href="{{ route('admin.logout') }}" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">All Bookings</h1>
            <p style="color: rgba(255, 255, 255, 0.7);">Manage and track all party bookings</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.bookings') }}">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="status">Payment Status</label>
                        <select name="status" id="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="plan">Plan Type</label>
                        <select name="plan" id="plan">
                            <option value="">All Plans</option>
                            <option value="IP" {{ request('plan') == 'IP' ? 'selected' : '' }}>IP</option>
                            <option value="VIP" {{ request('plan') == 'VIP' ? 'selected' : '' }}>VIP</option>
                            <option value="VVIP" {{ request('plan') == 'VVIP' ? 'selected' : '' }}>VVIP</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="search">Search</label>
                        <input type="text" name="search" id="search" placeholder="Search by name or email..." value="{{ request('search') }}">
                    </div>
                    
                    <div class="filter-group">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bookings Table -->
        <div class="bookings-table-container">
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
                            <th>M-Pesa Code</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>
                                    <strong style="color: #FF2E63;">#{{ $booking->id }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $booking->team_lead_name }}</strong><br>
                                        <small style="color: rgba(255,255,255,0.6)">{{ $booking->team_lead_email }}</small><br>
                                        <small style="color: rgba(255,255,255,0.6)">{{ $booking->team_lead_phone }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge" style="background: rgba(255,46,99,0.2); color: #FF2E63; border: 1px solid #FF2E63;">
                                        {{ $booking->plan_type }}
                                    </span>
                                </td>
                                <td>{{ $booking->group_size }} {{ $booking->group_size == 1 ? 'person' : 'people' }}</td>
                                <td>
                                    <strong style="color: #08D9D6;">KSH {{ number_format($booking->price) }}</strong>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $booking->payment_status }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->mpesa_code)
                                        <code style="background: rgba(255,255,255,0.1); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                            {{ $booking->mpesa_code }}
                                        </code>
                                    @else
                                        <span style="color: rgba(255,255,255,0.5); font-style: italic;">No code</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        {{ $booking->created_at->format('M j, Y') }}<br>
                                        <small style="color: rgba(255,255,255,0.6)">{{ $booking->created_at->format('g:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.booking.show', $booking) }}" class="btn btn-secondary" style="padding: 0.5rem; font-size: 0.8rem;">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $bookings->withQueryString()->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 4rem; color: rgba(255,255,255,0.6);">
                    <i class="fas fa-calendar-times" style="font-size: 4rem; margin-bottom: 2rem; opacity: 0.5;"></i>
                    <h3 style="margin-bottom: 1rem;">No bookings found</h3>
                    <p>There are no bookings matching your criteria.</p>
                    @if(request()->hasAny(['status', 'plan', 'search']))
                        <a href="{{ route('admin.bookings') }}" class="btn btn-secondary" style="margin-top: 1rem;">
                            <i class="fas fa-times"></i> Clear Filters
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</body>
</html>
