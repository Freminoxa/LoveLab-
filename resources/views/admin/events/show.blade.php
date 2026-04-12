<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }} - Admin Event Details</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #FF2E63;
            margin-bottom: 1rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
        }

        .stat-box {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1rem;
        }

        .stat-label {
            color: #94a3b8;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #08D9D6;
            font-weight: 600;
        }

        .form-input,
        .form-textarea,
        .form-select {
            width: 100%;
            padding: 0.8rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.08);
            color: white;
            font-size: 0.95rem;
        }

        .form-textarea {
            min-height: 170px;
            resize: vertical;
        }

        .btn {
            padding: 0.75rem 1.2rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
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

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.5);
            color: #6ee7b7;
            border-radius: 10px;
            padding: 0.9rem 1rem;
            margin-bottom: 1rem;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #fca5a5;
            border-radius: 10px;
            padding: 0.9rem 1rem;
            margin-bottom: 1rem;
        }

        .package-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 0.8rem;
            padding: 0.8rem;
            background: rgba(255,255,255,0.03);
            border-radius: 8px;
            margin-bottom: 0.6rem;
        }

        .hint {
            color: #cbd5e1;
            font-size: 0.9rem;
        }

        .brand-note {
            background: rgba(255, 46, 99, 0.12);
            border: 1px solid rgba(255, 46, 99, 0.35);
            border-radius: 10px;
            padding: 0.8rem 1rem;
            color: #fbcfe8;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="admin-navbar">
        <div class="navbar-content">
            <div class="navbar-brand">
                <i class="fas fa-shield-alt"></i> Admin Panel
            </div>
            <div class="navbar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a href="{{ route('admin.events.index') }}" class="nav-link"><i class="fas fa-calendar-alt"></i> Events</a>
                <a href="{{ route('admin.bookings') }}" class="nav-link"><i class="fas fa-ticket-alt"></i> Bookings</a>
                <a href="{{ route('admin.logout') }}" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <div class="detail-card">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <h1 class="text-3xl font-black text-white">{{ $event->name }}</h1>
                <div class="flex gap-2">
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-secondary"><i class="fas fa-edit"></i> Edit Event</a>
                    <a href="{{ route('admin.events.export', $event) }}" class="btn btn-secondary"><i class="fas fa-file-csv"></i> Export Bookings</a>
                </div>
            </div>
            <div class="grid-3">
                <div class="stat-box">
                    <div class="stat-label">Date</div>
                    <div class="stat-value">{{ $event->date->format('M d, Y - h:i A') }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Location</div>
                    <div class="stat-value">{{ $event->location }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Manager</div>
                    <div class="stat-value">{{ $event->manager?->name ?? 'Not Assigned' }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Status</div>
                    <div class="stat-value">{{ ucfirst($event->status) }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Total Bookings</div>
                    <div class="stat-value">{{ $event->bookings->count() }}</div>
                </div>
                <div class="stat-box">
                    <div class="stat-label">Confirmed Revenue</div>
                    <div class="stat-value">KSH {{ number_format($event->bookings->where('payment_status', 'confirmed')->sum('price')) }}</div>
                </div>
            </div>
        </div>

        <div class="detail-card">
            <h2 class="card-title"><i class="fas fa-box-open"></i> Package Performance</h2>
            @forelse($packageStats as $stat)
                <div class="package-row">
                    <div>
                        <div class="font-semibold text-white">{{ $stat['name'] }}</div>
                        <div class="hint">Confirmed bookings: {{ $stat['bookings_count'] }}</div>
                    </div>
                    <div>
                        <div class="stat-label">Tickets</div>
                        <div class="text-white font-semibold">{{ $stat['tickets_sold'] }}</div>
                    </div>
                    <div>
                        <div class="stat-label">Revenue</div>
                        <div class="text-green-400 font-semibold">KSH {{ number_format($stat['revenue']) }}</div>
                    </div>
                </div>
            @empty
                <p class="hint">No packages for this event yet.</p>
            @endforelse
        </div>

        <div class="detail-card">
            <h2 class="card-title"><i class="fas fa-envelope"></i> Email Attendees</h2>
            <p class="hint mb-4">Send one message to all attendee emails for this specific event. Team lead and member emails are included.</p>
            <div class="brand-note mb-4">
                <strong>Tikoikoon Style:</strong> Premium, high-energy, and professional messaging from Tikoikoon Technologies on tikoikoon.co.ke.
            </div>

            <form method="POST" action="{{ route('admin.events.email-attendees', $event) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="form-label" for="subject">Email Subject</label>
                    <input
                        id="subject"
                        name="subject"
                        type="text"
                        class="form-input"
                        value="{{ old('subject', 'Message from Tikoikoon Technologies: ' . $event->name) }}"
                        maxlength="200"
                        required
                    >
                </div>

                <div>
                    <label class="form-label" for="message">Main Message</label>
                    <textarea id="message" name="message" class="form-textarea" required>{{ old('message', "Dear Community,\n\nFrom Tikoikoon Technologies, we are pleased to share strategic updates for {$event->name} on tikoikoon.co.ke.\n\nThank you for trusting our platform as we continue building premium event experiences with stronger partnerships and measurable value for every stakeholder.\n\nWe look forward to welcoming you.") }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center gap-2 text-white">
                        <input type="checkbox" name="include_promo" value="1" {{ old('include_promo', '1') ? 'checked' : '' }}>
                        Include Tikoikoon Technologies promo message
                    </label>

                    <label class="flex items-center gap-2 text-white">
                        <input type="checkbox" name="include_pending" value="1" {{ old('include_pending') ? 'checked' : '' }}>
                        Include pending booking emails too
                    </label>
                </div>

                <div>
                    <label class="form-label" for="photo_urls">Event Photo URLs</label>
                    <textarea
                        id="photo_urls"
                        name="photo_urls"
                        class="form-textarea"
                        style="min-height: 120px;"
                        placeholder="Add one URL per line, or comma separated"
                    >{{ old('photo_urls') }}</textarea>
                </div>

                <div>
                    <label class="form-label" for="feedback_form_url">Google Form Feedback URL</label>
                    <input
                        id="feedback_form_url"
                        name="feedback_form_url"
                        type="url"
                        class="form-input"
                        placeholder="https://forms.gle/..."
                        value="{{ old('feedback_form_url') }}"
                    >
                    <p class="hint mt-2">Optional. Leave blank if no feedback form is ready yet.</p>
                </div>

                <input type="hidden" name="audience" id="audience-input" value="{{ old('audience', 'event_attendees') }}">

                <p class="hint mt-2">
                    Promo policy: Event managers earn a fixed <strong>20%</strong> commission on revenue from their exclusive event on tikoikoon.co.ke.
                </p>

                <div class="pt-2 flex flex-wrap gap-3">
                    <button type="submit" class="btn btn-primary" onclick="document.getElementById('audience-input').value='event_attendees'">
                        <i class="fas fa-paper-plane"></i> Send To This Event Audience
                    </button>
                    <button type="submit" class="btn btn-secondary" onclick="document.getElementById('audience-input').value='all_system'">
                        <i class="fas fa-bullhorn"></i> Send To All People In System
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
