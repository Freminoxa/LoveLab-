@extends('layout')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">{{ $event->name }}</h1>
                <p class="text-white/70">Event Management & Bookings</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.bookings.export', $event) }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>Export CSV
                </a>
                <a href="{{ route('admin.events.edit', $event) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit Event
                </a>
                <a href="{{ route('admin.events.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Events
                </a>
            </div>
        </div>

        <!-- Event Details Card -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 mb-8">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xl font-semibold text-white mb-4">Event Information</h3>
                    <div class="space-y-3 text-white/80">
                        <p><i class="fas fa-calendar mr-3 text-pink-400"></i><strong>Date:</strong> {{ $event->date->format('l, F j, Y - g:i A') }}</p>
                        <p><i class="fas fa-map-marker-alt mr-3 text-pink-400"></i><strong>Location:</strong> {{ $event->location }}</p>
                        <p><i class="fas fa-credit-card mr-3 text-pink-400"></i><strong>Till Number:</strong> {{ $event->till_number ?? 'Not set' }}</p>
                        <p><i class="fas fa-user-shield mr-3 text-pink-400"></i><strong>Manager:</strong> {{ $event->manager ? $event->manager->name : 'Not assigned' }}</p>
                        <p><i class="fas fa-info-circle mr-3 text-pink-400"></i><strong>Status:</strong> 
                            <span class="px-2 py-1 rounded text-sm {{ $event->status === 'published' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                
                @if($event->poster)
                <div class="text-center">
                    <img src="{{ asset('storage/' . $event->poster) }}" 
                         alt="{{ $event->name }}" 
                         class="w-48 h-48 object-cover rounded-lg mx-auto">
                </div>
                @endif
            </div>
            
            @if($event->description)
            <div class="mt-6 pt-6 border-t border-white/20">
                <h4 class="text-white font-semibold mb-2">Description</h4>
                <p class="text-white/80">{{ $event->description }}</p>
            </div>
            @endif
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 text-center">
                <div class="text-3xl font-bold text-blue-400 mb-2">{{ $event->bookings->count() }}</div>
                <div class="text-white/80">Total Bookings</div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 text-center">
                <div class="text-3xl font-bold text-green-400 mb-2">{{ $event->bookings->where('payment_status', 'confirmed')->count() }}</div>
                <div class="text-white/80">Confirmed</div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 text-center">
                <div class="text-3xl font-bold text-yellow-400 mb-2">{{ $event->bookings->where('payment_status', 'pending')->count() }}</div>
                <div class="text-white/80">Pending</div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 text-center">
                <div class="text-3xl font-bold text-pink-400 mb-2">KSH {{ number_format($event->bookings->where('payment_status', 'confirmed')->sum('price')) }}</div>
                <div class="text-white/80">Revenue</div>
            </div>
        </div>

        <!-- Packages -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 mb-8">
            <h3 class="text-xl font-semibold text-white mb-4">Ticket Packages</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($event->packages as $package)
                <div class="bg-white/5 rounded-lg p-4 border border-white/10">
                    <h4 class="text-white font-semibold mb-2">{{ $package->name }}</h4>
                    <div class="text-white/80 text-sm space-y-1">
                        <p><i class="fas fa-tag mr-2"></i>KSH {{ number_format($package->price) }}</p>
                        <p><i class="fas fa-users mr-2"></i>{{ $package->group_size }} {{ $package->group_size > 1 ? 'people' : 'person' }}</p>
                        @if($package->available_tickets)
                        <p><i class="fas fa-ticket-alt mr-2"></i>{{ $package->available_tickets }} available</p>
                        @endif
                        <p><i class="fas fa-shopping-cart mr-2"></i>{{ $package->bookings->where('payment_status', 'confirmed')->count() }} sold</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-white">Recent Bookings</h3>
                <a href="{{ route('admin.bookings') }}?event={{ $event->id }}" 
                   class="text-pink-400 hover:text-pink-300">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($event->bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-white/80">
                    <thead>
                        <tr class="border-b border-white/20">
                            <th class="text-left py-2">Ticket #</th>
                            <th class="text-left py-2">Customer</th>
                            <th class="text-left py-2">Package</th>
                            <th class="text-left py-2">Amount</th>
                            <th class="text-left py-2">Status</th>
                            <th class="text-left py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->bookings->take(10) as $booking)
                        <tr class="border-b border-white/10 hover:bg-white/5">
                            <td class="py-3">
                                <span class="font-mono text-pink-400">{{ $booking->ticket_number }}</span>
                            </td>
                            <td class="py-3">
                                <div>
                                    <div class="font-semibold">{{ $booking->team_lead_name }}</div>
                                    <div class="text-sm text-white/60">{{ $booking->team_lead_email }}</div>
                                </div>
                            </td>
                            <td class="py-3">{{ $booking->package ? $booking->package->name : $booking->plan_type }}</td>
                            <td class="py-3">KSH {{ number_format($booking->price) }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 rounded text-xs {{ 
                                    $booking->payment_status === 'confirmed' ? 'bg-green-500/20 text-green-400' : 
                                    ($booking->payment_status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') 
                                }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </td>
                            <td class="py-3 text-sm">{{ $booking->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8 text-white/60">
                <i class="fas fa-ticket-alt text-4xl mb-2"></i>
                <p>No bookings yet</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection