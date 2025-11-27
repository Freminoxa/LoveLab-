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

        .export-button {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .export-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
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
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}"
                        alt="{{ $event->name }}"
                        class="w-16 h-16 rounded-lg object-cover">
                    @endif

                    <div>
                        <h1 class="text-2xl font-bold text-white mb-2">{{ $event->name }}</h1>
                        <div class="space-y-1 text-white/80">
                            <p><i class="fas fa-calendar mr-2"></i>{{ $event->date->format('F j, Y - g:i A') }}</p>
                            <p><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}</p>
                            @if($event->till_number)
                            <p><i class="fas fa-credit-card mr-2"></i>Till: {{ $event->till_number }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <div class="text-3xl font-bold text-pink-400">{{ $bookings->count() }}</div>
                    <div class="text-white/80">Total Bookings</div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-4 border border-white/20 text-center">
                <div class="text-2xl font-bold text-blue-400">{{ $bookings->where('payment_status', 'confirmed')->count() }}</div>
                <div class="text-white/80 text-sm">Confirmed</div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-4 border border-white/20 text-center">
                <div class="text-2xl font-bold text-yellow-400">{{ $bookings->where('payment_status', 'pending')->count() }}</div>
                <div class="text-white/80 text-sm">Pending</div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-4 border border-white/20 text-center">
                <div class="text-2xl font-bold text-green-400">{{ $bookings->where('is_verified', true)->count() }}</div>
                <div class="text-white/80 text-sm">Verified</div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-4 border border-white/20 text-center">
                <div class="text-2xl font-bold text-purple-400">{{ $bookings->where('has_attended', true)->count() }}</div>
                <div class="text-white/80 text-sm">Attended</div>
            </div>
            <div class="bg-white/10 backdrop-blur-lg rounded-xl p-4 border border-white/20 text-center">
                <div class="text-2xl font-bold text-pink-400">KSH {{ number_format($bookings->where('payment_status', 'confirmed')->sum('price')) }}</div>
                <div class="text-white/80 text-sm">Revenue</div>
            </div>
        </div>
                <div class="text-white/80 text-sm">Revenue</div>
            </div>
        </div>

        <!-- Bookings Table & Search Bar -->
        <div class="bg-white/10 backdrop-blur-lg rounded-xl border border-white/20 overflow-hidden">
            <div class="p-6 border-b border-white/20">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-white">Event Bookings</h2>
                    <div class="flex gap-3">
                        <button onclick="window.print()"
                            class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-print mr-2"></i>Print
                        </button>
                        <button onclick="exportToCSV()" class="export-button">
                            <i class="fas fa-download mr-2"></i>Export CSV
                        </button>
                    </div>
                </div>
                <!-- Search Bar -->
                <div class="mb-4">
                    <input type="text" id="attendee-search" class="w-full px-4 py-2 rounded-lg bg-black/20 text-white border border-white/20 focus:outline-none focus:ring-2 focus:ring-pink-400" placeholder="Search by ticket number, name, email, or phone..." oninput="filterBookings()">
                </div>
            </div>

            @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-white/80 text-sm" id="bookings-table">
                    <thead class="bg-white/5">
                        <tr>
                            <th class="text-left p-4">Ticket #</th>
                            <th class="text-left p-4">Customer Details</th>
                            <th class="text-left p-4">Package</th>
                            <th class="text-left p-4">Group</th>
                            <th class="text-left p-4">Amount</th>
                            <th class="text-left p-4">M-Pesa Code</th>
                            <th class="text-left p-4">Status</th>
                            <th class="text-left p-4">Attendance</th>
                            <th class="text-left p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bookings-tbody">
                        @foreach($bookings as $booking)
                        <tr class="border-b border-white/10 hover:bg-white/5">
                            <td class="p-4">
                                <span class="font-mono text-pink-400 font-bold">{{ $booking->ticket_number }}</span>
                                @if($booking->is_verified)
                                <br><span class="text-green-400 text-xs">
                                    <i class="fas fa-check-circle mr-1"></i>Verified
                                </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div>
                                    <div class="font-semibold text-white">{{ $booking->team_lead_name }}</div>
                                    <div class="text-xs">{{ $booking->team_lead_email }}</div>
                                    <div class="text-xs">{{ $booking->team_lead_phone }}</div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="bg-pink-500/20 text-pink-400 px-2 py-1 rounded text-xs">
                                    {{ $booking->package ? $booking->package->name : $booking->plan_type }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-white">{{ $booking->group_size }}</div>
                                    <div class="text-xs">{{ $booking->group_size > 1 ? 'people' : 'person' }}</div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="font-bold text-green-400">KSH {{ number_format($booking->price) }}</div>
                            </td>
                            <td class="p-4">
                                @if($booking->mpesa_code)
                                <span class="font-mono text-xs bg-gray-700 px-2 py-1 rounded">{{ $booking->mpesa_code }}</span>
                                @else
                                <span class="text-white/50">-</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-xs {{ 
                                    $booking->payment_status === 'confirmed' ? 'bg-green-500/20 text-green-400' : 
                                    ($booking->payment_status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') 
                                }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($booking->has_attended)
                                <div class="text-center">
                                    <span class="bg-purple-500/20 text-purple-400 px-2 py-1 rounded text-xs">
                                        <i class="fas fa-user-check mr-1"></i>Attended
                                    </span>
                                    @if($booking->attended_at)
                                    <div class="text-xs text-white/50 mt-1">
                                        {{ $booking->attended_at->format('M d, h:i A') }}
                                    </div>
                                    @endif
                                </div>
                                @else
                                <div class="text-center">
                                    <span class="bg-gray-500/20 text-gray-400 px-2 py-1 rounded text-xs">
                                        <i class="fas fa-user-clock mr-1"></i>Not Attended
                                    </span>
                                </div>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($booking->payment_status === 'pending')
                                <div class="flex flex-col gap-2">
                                    <div class="flex gap-2">
                                        <form action="{{ route('manager.booking.confirm', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-500/20 hover:bg-green-500/30 text-green-400 px-3 py-1 rounded text-xs transition-colors"
                                                onclick="return confirm('Confirm this payment?')">
                                                <i class="fas fa-check mr-1"></i>Confirm
                                            </button>
                                        </form>
                                        <form action="{{ route('manager.booking.reject', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-1 rounded text-xs transition-colors"
                                                onclick="return confirm('Reject this payment?')">
                                                <i class="fas fa-times mr-1"></i>Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @elseif($booking->payment_status === 'confirmed')
                                <div class="flex flex-col gap-2">
                                    <form action="{{ route('manager.booking.attend', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @if($booking->has_attended)
                                            <button type="submit"
                                                class="w-full bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-1 rounded text-xs transition-colors"
                                                onclick="return confirm('Remove attendance confirmation?')">
                                                <i class="fas fa-user-minus mr-1"></i>Remove
                                            </button>
                                        @else
                                            <button type="submit"
                                                class="w-full bg-green-500/20 hover:bg-green-500/30 text-green-400 px-3 py-1 rounded text-xs transition-colors"
                                                onclick="return confirm('Confirm attendance?')">
                                                <i class="fas fa-user-check mr-1"></i>Attend
                                            </button>
                                        @endif
                                    </form>
                                </div>
                                @else
                                <span class="text-white/50 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-8 text-center text-white/60">
                <i class="fas fa-inbox text-4xl mb-2 block"></i>
                <p>No bookings yet</p>
            </div>
            @endif
        </div>
    </div>

    <script>
        function exportToCSV() {
            {
                window.location.href = "{{ route('manager.export.bookings', ['event' => $event->id]) }}";
            }
        }

        function filterBookings() {
            const search = document.getElementById('attendee-search').value.toLowerCase();
            const table = document.getElementById('bookings-table');
            const tbody = document.getElementById('bookings-tbody');
            if (!table || !tbody) return;
            Array.from(tbody.rows).forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        }
    </script>
</body>

</html>
