<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Bookings - {{ $event->name }}</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-black/20 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('manager.dashboard') }}" class="text-white hover:text-pink-400 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
                <div class="text-white">
                    <i class="fas fa-user-shield mr-2"></i>{{ session('manager_name') }}
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-white px-4 py-3 rounded-lg mb-6 animate-pulse">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- Event Header -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-6 border border-white/20 mb-6">
            <div class="flex items-start space-x-4">
                @if($event->poster)
                <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->name }}" class="w-24 h-24 rounded-lg object-cover">
                @else
                <div class="w-24 h-24 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-star text-white text-3xl"></i>
                </div>
                @endif
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $event->name }}</h1>
                    <p class="text-white/70">
                        <i class="fas fa-calendar mr-2"></i>{{ $event->date->format('F d, Y - h:i A') }}
                    </p>
                    <p class="text-white/70">
                        <i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-green-400 mb-1">
                        KSH {{ number_format($event->bookings->where('payment_status', 'confirmed')->sum('price')) }}
                    </div>
                    <div class="text-white/70 text-sm">Total Revenue</div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 border border-white/20">
                <div class="text-white/70 text-sm">Total Bookings</div>
                <div class="text-2xl font-bold text-white">{{ $bookings->count() }}</div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 border border-white/20">
                <div class="text-white/70 text-sm">Pending Confirmation</div>
                <div class="text-2xl font-bold text-yellow-400">{{ $bookings->where('payment_status', 'pending')->count() }}</div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-lg p-4 border border-white/20">
                <div class="text-white/70 text-sm">Confirmed</div>
                <div class="text-2xl font-bold text-green-400">{{ $bookings->where('payment_status', 'confirmed')->count() }}</div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl border border-white/20 overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-white mb-4">
                    <i class="fas fa-ticket-alt mr-2"></i>All Bookings
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left text-white/70 font-medium py-3 px-4">ID</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Customer</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Package</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Tickets</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Amount</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">M-Pesa Code</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Status</th>
                                <th class="text-left text-white/70 font-medium py-3 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                <td class="py-4 px-4 text-white">#{{ $booking->id }}</td>
                                <td class="py-4 px-4">
                                    <div class="text-white font-medium">{{ $booking->team_lead_name }}</div>
                                    <div class="text-white/60 text-sm">{{ $booking->team_lead_email }}</div>
                                    <div class="text-white/60 text-sm">{{ $booking->team_lead_phone }}</div>
                                </td>
                                <td class="py-4 px-4 text-white">{{ $booking->package->name ?? $booking->plan_type }}</td>
                                <td class="py-4 px-4 text-white">{{ $booking->group_size }}</td>
                                <td class="py-4 px-4 text-white font-semibold">KSH {{ number_format($booking->price) }}</td>
                                <td class="py-4 px-4">
                                    @if($booking->mpesa_code)
                                        <span class="text-white font-mono bg-white/10 px-2 py-1 rounded">{{ $booking->mpesa_code }}</span>
                                    @else
                                        <span class="text-white/50">Pending</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if($booking->payment_status === 'confirmed')
                                        <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">
                                            <i class="fas fa-check-circle mr-1"></i>Confirmed
                                        </span>
                                    @elseif($booking->payment_status === 'pending')
                                        <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-sm">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                    @else
                                        <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-sm">
                                            <i class="fas fa-times-circle mr-1"></i>Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if($booking->payment_status === 'pending' && $booking->mpesa_code)
                                        <div class="flex gap-2">
                                            <form method="POST" action="{{ route('manager.booking.confirm', $booking->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition-colors">
                                                    <i class="fas fa-check mr-1"></i>Confirm
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('manager.booking.reject', $booking->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition-colors"
                                                        onclick="return confirm('Are you sure you want to reject this booking?')">
                                                    <i class="fas fa-times mr-1"></i>Reject
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($booking->payment_status === 'pending')
                                        <span class="text-white/50 text-sm">Awaiting payment</span>
                                    @else
                                        <span class="text-white/50 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-white/60">
                                    <i class="fas fa-inbox text-4xl mb-2 block"></i>
                                    <p>No bookings yet</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Export Options -->
        <div class="mt-6 flex justify-end gap-4">
            <button onclick="window.print()" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-print mr-2"></i>Print Report
            </button>
            <button onclick="exportToCSV()" class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-pink-600 hover:to-purple-700 transition-colors">
                <i class="fas fa-download mr-2"></i>Export CSV
            </button>
        </div>
    </div>

    <script>
        function exportToCSV() {
            const bookings = @json($bookings);
            let csv = 'ID,Customer Name,Email,Phone,Package,Tickets,Amount,M-Pesa Code,Status\n';
            
            bookings.forEach(booking => {
                csv += `${booking.id},${booking.team_lead_name},${booking.team_lead_email},${booking.team_lead_phone},${booking.package?.name || booking.plan_type},${booking.group_size},${booking.price},${booking.mpesa_code || 'N/A'},${booking.payment_status}\n`;
            });
            
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'event-bookings-{{ $event->id }}.csv';
            a.click();
        }
    </script>
</body>
</html>