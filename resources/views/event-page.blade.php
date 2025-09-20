@extends('layout')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative h-screen flex items-center justify-center overflow-hidden">
        @if($event->poster)
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . $event->poster) }}" 
                 alt="{{ $event->name }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
        @endif
        
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-6xl md:text-8xl font-bold mb-6 animate-pulse" 
                style="font-family: 'Orbitron', sans-serif;">
                {{ $event->name }}
            </h1>
            
            <div class="space-y-4 text-xl md:text-2xl mb-8">
                <p><i class="fas fa-calendar mr-3"></i>{{ $event->date->format('l, F j, Y - g:i A') }}</p>
                <p><i class="fas fa-map-marker-alt mr-3"></i>{{ $event->location }}</p>
                @if($event->till_number)
                <p><i class="fas fa-credit-card mr-3"></i>Till Number: {{ $event->till_number }}</p>
                @endif
            </div>
            
            @if($event->description)
            <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto mb-8">
                {{ $event->description }}
            </p>
            @endif
            
            <button onclick="scrollToPackages()" 
                    class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-4 rounded-full text-lg font-semibold hover:from-pink-600 hover:to-purple-700 transition-all transform hover:scale-105">
                <i class="fas fa-ticket-alt mr-2"></i>Get Your Tickets
            </button>
        </div>
    </div>
    
    <!-- Packages Section -->
    <div id="packages-section" class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-white text-center mb-12">
                Choose Your Package
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-{{ min($event->packages->count(), 3) }} gap-8">
                @foreach($event->packages as $package)
                <div class="package-card group">
                    <div class="package-header">
                        <div class="package-icon">{{ $package->icon ?? '🎫' }}</div>
                        <h3 class="package-title">{{ $package->name }}</h3>
                        <div class="package-price">
                            <span class="price-amount">KSH {{ number_format($package->price) }}</span>
                            @if($package->group_size > 1)
                                <span class="price-detail">for {{ $package->group_size }} people</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($package->description)
                    <div class="package-description">
                        {{ $package->description }}
                    </div>
                    @endif
                    
                    <div class="package-footer">
                        @if($package->hasAvailableTickets())
                            <button onclick="openBookingModal('{{ $package->name }}', {{ $package->group_size }}, {{ $package->price }}, '{{ $package->id }}')"
                                    class="package-button">
                                <i class="fas fa-shopping-cart mr-2"></i>Book Now
                            </button>
                        @else
                            <button disabled class="package-button-disabled">
                                <i class="fas fa-times mr-2"></i>Sold Out
                            </button>
                        @endif
                        
                        @if($package->available_tickets)
                        <p class="text-white/60 text-sm mt-2">
                            {{ $package->available_tickets - $package->bookings->where('payment_status', 'confirmed')->count() }} tickets left
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
function scrollToPackages() {
    document.getElementById('packages-section').scrollIntoView({ 
        behavior: 'smooth' 
    });
}

function openBookingModal(packageName, groupSize, price, packageId) {
    // Use existing booking modal logic
    openModal(packageName.toLowerCase().replace(' ', ''), groupSize, price, packageId);
}
</script>

<style>
.package-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 1.5rem;
    padding: 2rem;
    transition: all 0.3s ease;
    text-align: center;
}

.package-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
    border-color: rgba(255, 46, 99, 0.5);
}

.package-header {
    margin-bottom: 1.5rem;
}

.package-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.package-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
    margin-bottom: 1rem;
}

.package-price {
    margin-bottom: 1rem;
}

.price-amount {
    font-size: 2rem;
    font-weight: bold;
    color: #ff2e63;
}

.price-detail {
    display: block;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    margin-top: 0.25rem;
}

.package-description {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.package-button {
    background: linear-gradient(135deg, #ff2e63, #08d9d6);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 2rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.package-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(255, 46, 99, 0.3);
}

.package-button-disabled {
    background: rgba(255, 255, 255, 0.2);
    color: rgba(255, 255, 255, 0.5);
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 2rem;
    font-weight: bold;
    cursor: not-allowed;
    width: 100%;
}
</style>
@endsection