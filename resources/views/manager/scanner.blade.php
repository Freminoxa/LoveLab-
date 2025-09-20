{{-- resources/views/manager/scanner.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Scanner - {{ $event->name }}</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .event-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .event-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            background: white;
            padding: 20px;
            margin-top: 2px;
        }

        .stat-card {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .scanner-section {
            background: white;
            padding: 20px;
            margin-top: 2px;
        }

        #reader {
            max-width: 500px;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
        }

        .search-section {
            background: white;
            padding: 20px;
            margin-top: 2px;
            border-radius: 0 0 15px 15px;
        }

        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .result-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            display: none;
        }

        .result-card.show {
            display: block;
        }

        .result-card.success {
            border-left: 5px solid #28a745;
        }

        .result-card.error {
            border-left: 5px solid #dc3545;
        }

        .result-card.warning {
            border-left: 5px solid #ffc107;
        }

        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .detail-item {
            padding: 10px;
            background: white;
            border-radius: 5px;
        }

        .detail-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .search-results {
            margin-top: 15px;
            max-height: 400px;
            overflow-y: auto;
        }

        .result-item {
            padding: 15px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .result-item:hover {
            border-color: #667eea;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .verified-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }

        .verified-badge.verified {
            background: #d4edda;
            color: #155724;
        }

        .verified-badge.pending {
            background: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="event-info">
                <div>
                    <h1 class="event-name">{{ $event->name }}</h1>
                    <p style="color: #666; margin-top: 5px;">
                        {{ \Carbon\Carbon::parse($event->date)->format('F j, Y - g:i A') }}
                    </p>
                </div>
                <a href="{{ route('manager.dashboard') }}" class="btn btn-primary">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-value" id="total-tickets">0</div>
                <div class="stat-label">Total Tickets</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="verified-tickets">0</div>
                <div class="stat-label">Verified</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="pending-tickets">0</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="total-attendees">0</div>
                <div class="stat-label">Total Attendees</div>
            </div>
        </div>

        <!-- Scanner Section -->
        <div class="scanner-section">
            <h2 style="margin-bottom: 20px; text-align: center;">Scan QR Code</h2>
            <div id="reader"></div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <h3 style="margin-bottom: 15px;">Manual Search</h3>
            <div class="search-box">
                <input type="text" 
                       id="search-input" 
                       class="search-input" 
                       placeholder="Search by ticket number, name, email, or phone...">
                <button onclick="searchBooking()" class="btn btn-primary">Search</button>
            </div>

            <div id="search-results" class="search-results"></div>
        </div>

        <!-- Result Card -->
        <div id="result-card" class="result-card">
            <h3 id="result-title"></h3>
            <p id="result-message" style="margin-top: 10px;"></p>
            <div id="booking-details" class="booking-details"></div>
        </div>
    </div>

    <script>
        const eventId = {{ $event->id }};
        let html5QrCode = null;

        // Initialize QR Scanner
        function initializeScanner() {
            html5QrCode = new Html5Qrcode("reader");
            
            const config = { 
                fps: 10, 
                qrbox: { width: 250, height: 250 } 
            };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanError
            ).catch(err => {
                console.error('Error starting scanner:', err);
                document.getElementById('reader').innerHTML = 
                    '<p style="text-align: center; color: #dc3545;">Unable to access camera. Please check permissions.</p>';
            });
        }

        // Handle successful scan
        function onScanSuccess(decodedText, decodedResult) {
            // Pause scanning
            html5QrCode.pause();
            
            // Verify ticket
            verifyTicket(decodedText);
        }

        function onScanError(errorMessage) {
            // Silent error handling
        }

        // Verify ticket via API
        function verifyTicket(qrData) {
            fetch('/manager/verify-ticket', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ qr_data: qrData })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data);
                loadStats();
                
                // Resume scanning after 3 seconds
                setTimeout(() => {
                    if (html5QrCode) {
                        html5QrCode.resume();
                    }
                }, 3000);
            })
            .catch(error => {
                showError('Error verifying ticket: ' + error.message);
                setTimeout(() => {
                    if (html5QrCode) {
                        html5QrCode.resume();
                    }
                }, 3000);
            });
        }

        // Search booking
        function searchBooking() {
            const query = document.getElementById('search-input').value;
            
            if (!query) {
                return;
            }

            fetch(`/manager/search-booking?query=${encodeURIComponent(query)}&event_id=${eventId}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data.bookings);
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
        }

        // Display search results
        function displaySearchResults(bookings) {
            const resultsDiv = document.getElementById('search-results');
            
            if (bookings.length === 0) {
                resultsDiv.innerHTML = '<p style="text-align: center; color: #666;">No bookings found</p>';
                return;
            }

            resultsDiv.innerHTML = bookings.map(booking => `
                <div class="result-item" onclick="verifyManually('${booking.ticket_number}')">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong>${booking.ticket_number}</strong>
                            <span class="verified-badge ${booking.is_verified ? 'verified' : 'pending'}">
                                ${booking.is_verified ? '✓ Verified' : 'Pending'}
                            </span>
                            <p style="margin-top: 5px; color: #666;">
                                ${booking.team_lead_name} - ${booking.group_size} person(s)
                            </p>
                        </div>
                        <button class="btn btn-success" style="padding: 8px 16px;">
                            Verify
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // Manual verification
        function verifyManually(ticketNumber) {
            fetch('/manager/manual-verification', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    ticket_number: ticketNumber,
                    event_id: eventId 
                })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data);
                loadStats();
                
                // Refresh search results
                searchBooking();
            })
            .catch(error => {
                showError('Error: ' + error.message);
            });
        }

        // Show verification result
        function showResult(data) {
            const resultCard = document.getElementById('result-card');
            const resultTitle = document.getElementById('result-title');
            const resultMessage = document.getElementById('result-message');
            const bookingDetails = document.getElementById('booking-details');

            resultCard.className = 'result-card show';
            
            if (data.success) {
                resultCard.classList.add(data.already_verified ? 'warning' : 'success');
                resultTitle.textContent = data.already_verified ? 
                    '⚠️ Already Verified!' : '✅ Ticket Verified!';
                resultMessage.textContent = data.message;

                if (data.booking) {
                    bookingDetails.innerHTML = `
                        <div class="detail-item">
                            <div class="detail-label">Ticket Number</div>
                            <div class="detail-value">${data.booking.ticket_number}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Name</div>
                            <div class="detail-value">${data.booking.team_lead_name}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Package</div>
                            <div class="detail-value">${data.booking.package?.name || data.booking.plan_type}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Group Size</div>
                            <div class="detail-value">${data.booking.group_size} person(s)</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Scan Count</div>
                            <div class="detail-value">${data.verification_count}</div>
                        </div>
                    `;
                }
            } else {
                resultCard.classList.add('error');
                resultTitle.textContent = '❌ Verification Failed';
                resultMessage.textContent = data.message;
                bookingDetails.innerHTML = '';
            }

            // Auto-hide after 5 seconds
            setTimeout(() => {
                resultCard.classList.remove('show');
            }, 5000);
        }

        // Show error
        function showError(message) {
            const resultCard = document.getElementById('result-card');
            const resultTitle = document.getElementById('result-title');
            const resultMessage = document.getElementById('result-message');
            const bookingDetails = document.getElementById('booking-details');

            resultCard.className = 'result-card show error';
            resultTitle.textContent = '❌ Error';
            resultMessage.textContent = message;
            bookingDetails.innerHTML = '';

            setTimeout(() => {
                resultCard.classList.remove('show');
            }, 3000);
        }

        // Load statistics
        function loadStats() {
            fetch(`/manager/verification-stats/${eventId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('total-tickets').textContent = data.stats.total_tickets;
                        document.getElementById('verified-tickets').textContent = data.stats.verified_tickets;
                        document.getElementById('pending-tickets').textContent = data.stats.pending_verification;
                        document.getElementById('total-attendees').textContent = data.stats.total_attendees;
                    }
                });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeScanner();
            loadStats();

            // Add enter key support for search
            document.getElementById('search-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchBooking();
                }
            });
        });
    </script>
</body>
</html>