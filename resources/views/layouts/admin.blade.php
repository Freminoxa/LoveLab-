<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
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

        /* Navbar */
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

        /* Container */
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Buttons */
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
                <a href="{{ route('admin.events.index') }}" class="nav-link">
                    <i class="fas fa-calendar-alt"></i> Events
                </a>
                <a href="{{ route('admin.bookings') }}" class="nav-link">
                    <i class="fas fa-ticket-alt"></i> Bookings
                </a>
                <a href="{{ route('admin.logout') }}" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="admin-container">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
