<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tiko Iko On - Ultimate Party Experience')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Experience the ultimate party atmosphere at Tiko Iko On - Kenya\'s premier event destination. Book exclusive VIP packages, group events, and unforgettable entertainment experiences.')">
    <meta name="keywords" content="@yield('keywords', 'Tiko Iko On, parties Kenya, events Kenya, entertainment, VIP packages, group bookings, nightlife, premium events, party venue, event booking, Kenya entertainment')">
    <meta name="author" content="Tiko Iko On">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="@yield('og:type', 'website')">
    <meta property="og:title" content="@yield('og:title', 'Tiko Iko On - Ultimate Party Experience')">
    <meta property="og:description" content="@yield('og:description', 'Join the most exclusive events in Kenya. From intimate vibes to massive celebrations - we\'ve got your perfect party waiting! 🔥')">
    <meta property="og:image" content="@yield('og:image', asset('images/logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter:title', 'Tiko Iko On - Ultimate Party Experience')">
    <meta name="twitter:description" content="@yield('twitter:description', 'Experience Kenya\'s premier entertainment destination. Book exclusive events and VIP packages.')">
    <meta name="twitter:image" content="@yield('twitter:image', asset('images/logo.png'))">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="party-theme">
    @include('partials.navbar')
    
    @yield('content')
    
    @include('partials.footer')
    
    @stack('scripts')
</body>
</html>
