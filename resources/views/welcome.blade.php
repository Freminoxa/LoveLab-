<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Table</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
</head>
<body>
    @if (session('success'))
        <div class="success-message">
            <div class="success-content">
                <span class="heart-icon">❤️</span>
                <p>{{ session('success') }}</p>
                <span class="heart-icon">❤️</span>
            </div>
        </div>
    @endif

    <div class="pricing-table">
        <!-- Your existing content remains exactly the same -->
        <div class="plan ip">
            <h3>IP</h3>
            <button class="pricing-category">
                <h4>Single</h4>
                <p>500Ksh/ 1 ticket</p>
            </button>
            <button class="pricing-category">
                <h4>Couple</h4>
                <p>800Ksh/2 tickets</p>
            </button>
            <button class="pricing-category">
                <h4>Group of 6</h4>
                <p>1500Ksh/6 tickets</p>
            </button>
        </div>
        <div class="plan vip">
            <h3>VIP</h3>
            <button class="pricing-category">
                <h4>Single</h4>
                <p>1000Ksh/1 ticket</p>
            </button>
            <button class="pricing-category">
                <h4>Couple</h4>
                <p>1800Ksh/2 tickets</p>
            </button>
            <button class="pricing-category">
                <h4>Group of 6</h4>
                <p>4500Ksh/6 tickets</p>
            </button>
        </div>
    </div>
</body>
</html>