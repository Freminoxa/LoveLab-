<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - Admin</title>
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
        
        .detail-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #FF2E63;
            margin-bottom: 0.5rem;
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .detail-item {
            margin-bottom: 1rem;
        }
        
        .detail-label {
            color: #08D9D6;
            font-weight: 600;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        .detail-value {
            color: white;
            font-size: 1.1rem;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
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
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-right: 1rem;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
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
        
        .members-list {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            padding: 1rem;
        }
        
        .member-item {
            padding: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .member-item:last-child {
            border-bottom: none;
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
                <a href="{{ route('admin.logout') }}" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Booking Details -->
        <div class="detail-card">
            <div class="card-header">
                <h1 class="card-title">
                    <i class="fas fa-ticket-alt"></i> Booking #{{ $booking->id }}
                </h1>
                <p style="color: rgba(255,255,255,0.7);">Created on {{ $booking->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Plan Type</div>
                    <div class="detail-value">
                        <span class="status-badge" style="background: rgba(255,46,99,0.2); color: #FF2E63; border: 1px solid #FF2E63;">
                            {{ $booking->plan_type }}
                        </span>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Group Size</div>
                    <div class="detail-value">{{ $booking->group_size }} {{ $booking->group_size == 1 ? 'person' : 'people' }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Total Amount</div>
                    <div class="detail-value" style="font-size: 1.5rem; font-weight: 700; color: #FF2E63;">
                        KSH {{ number_format($booking->price) }}
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Payment Status</div>
                    <div class="detail-value">
                        <span class="status-badge status-{{ $booking->payment_status }}">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Lead Information -->
        <div class="detail-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-user-crown"></i> Team Lead Information
                </h2>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Full Name</div>
                    <div class="detail-value">{{ $booking->team_lead_name }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Email Address</div>
                    <div class="detail-value">
                        <a href="mailto:{{ $booking->team_lead_email }}" style="color: #08D9D6; text-decoration: none;">
                            {{ $booking->team_lead_email }}
                        </a>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Phone Number</div>
                    <div class="detail-value">
                        <a href="tel:{{ $booking->team_lead_phone }}" style="color: #08D9D6; text-decoration: none;">
                            {{ $booking->team_lead_phone }}
                        </a>
                    </div>
                </div>

                @if($booking->mpesa_code)
                <div class="detail-item">
                    <div class="detail-label">M-Pesa Code</div>
                    <div class="detail-value" style="font-family: monospace; background: rgba(255,255,255,0.1); padding: 0.5rem; border-radius: 5px; display: inline-block;">
                        {{ $booking->mpesa_code }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Team Members -->
        @if($booking->members && count($booking->members) > 0)
        <div class="detail-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-users"></i> Team Members ({{ count($booking->members) }})
                </h2>
            </div>

            <div class="members-list">
                @foreach($booking->members as $index => $member)
                <div class="member-item">
                    <div>
                        <strong>{{ $member['name'] }}</strong><br>
                        <small style="color: rgba(255,255,255,0.6)">{{ $member['email'] }}</small>
                    </div>
                    <div style="color: #08D9D6; font-weight: 600;">
                        Member {{ $index + 1 }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Payment Status Update -->
        <div class="detail-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-edit"></i> Update Payment Status
                </h2>
            </div>

            <form method="POST" action="{{ route('admin.booking.update-payment', $booking) }}">
                @csrf
                @method('PATCH')
                
                <p style="margin-bottom: 1.5rem; color: rgba(255,255,255,0.7);">
                    Current status: <span class="status-badge status-{{ $booking->payment_status }}">{{ ucfirst($booking->payment_status) }}</span>
                </p>

                <div style="margin-bottom: 2rem;">
                    <button type="submit" name="payment_status" value="confirmed" class="btn btn-success">
                        <i class="fas fa-check"></i> Mark as Confirmed
                    </button>
                    
                    <button type="submit" name="payment_status" value="pending" class="btn btn-warning">
                        <i class="fas fa-clock"></i> Mark as Pending
                    </button>
                    
                    <button type="submit" name="payment_status" value="failed" class="btn btn-danger">
                        <i class="fas fa-times"></i> Mark as Failed
                    </button>
                </div>
            </form>

            <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to All Bookings
            </a>
        </div>
    </div>
</body>
</html>
