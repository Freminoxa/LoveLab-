{{-- resources/views/emails/ticket-confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Confirmation - Tiko Iko On</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #FF2E63, #08D9D6);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        
        .emoji {
            font-size: 50px;
            margin-bottom: 10px;
            display: block;
        }
        
        .content {
            padding: 30px;
        }
        
        .ticket-box {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
            color: white;
            text-align: center;
        }
        
        .ticket-number {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 10px 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .details-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        
        .details-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .details-table td:first-child {
            font-weight: bold;
            color: #666;
            width: 40%;
        }
        
        .qr-code-container {
            background: #f8f9fa;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        
        .qr-code-img {
            max-width: 250px;
            height: auto;
            margin: 15px auto;
            display: block;
        }
        
        .important-info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #FF2E63, #08D9D6);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <span class="emoji">🎆</span>
            <h1>Tiko Iko On</h1>
            <p style="margin: 5px 0 0; font-size: 18px;">Your Ticket is Confirmed!</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2 style="color: #FF2E63; margin-top: 0;">🎉 Congratulations, {{ $booking->team_lead_name }}!</h2>
            
            <p>Your payment has been confirmed and your ticket is ready! Get ready to party at <strong>{{ $event->name }}</strong>!</p>

            <!-- Ticket Box -->
            <div class="ticket-box">
                <p style="margin: 0; font-size: 14px; opacity: 0.9;">Your Ticket Number</p>
                <div class="ticket-number">{{ $ticketNumber }}</div>
                <p style="margin: 10px 0 0; font-size: 14px; opacity: 0.9;">Keep this number safe!</p>
            </div>

            <!-- Event Details -->
            <h3 style="color: #08D9D6;">📅 Event Details</h3>
            <table class="details-table">
                <tr>
                    <td>Event Name</td>
                    <td>{{ $event->name }}</td>
                </tr>
                <tr>
                    <td>Date & Time</td>
                    <td>{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y - g:i A') }}</td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td>{{ $event->location }}</td>
                </tr>
                @if($event->description)
                <tr>
                    <td>Description</td>
                    <td>{{ $event->description }}</td>
                </tr>
                @endif
                <tr>
                    <td>Package</td>
                    <td>{{ $package->name ?? $booking->plan_type }}</td>
                </tr>
                <tr>
                    <td>Number of People</td>
                    <td>{{ $booking->group_size }} {{ $booking->group_size > 1 ? 'people' : 'person' }}</td>
                </tr>
                <tr>
                    <td>Amount Paid</td>
                    <td><strong>KSH {{ number_format($booking->price) }}</strong></td>
                </tr>
            </table>

            @if($booking->members && count($booking->members) > 0)
            <!-- Team Members -->
            <h3 style="color: #08D9D6;">👥 Team Members</h3>
            <ul style="list-style: none; padding: 0;">
                <li style="padding: 8px 0; border-bottom: 1px solid #eee;">
                    <strong>Team Lead:</strong> {{ $booking->team_lead_name }} ({{ $booking->team_lead_email }})
                </li>
                @foreach($booking->members as $index => $member)
                <li style="padding: 8px 0; border-bottom: 1px solid #eee;">
                    <strong>Member {{ $index + 1 }}:</strong> {{ $member['name'] ?? 'N/A' }} 
                    @if(isset($member['email']) && $member['email'])
                        ({{ $member['email'] }})
                    @endif
                </li>
                @endforeach
            </ul>
            @endif

            <!-- QR Code -->
            <div class="qr-code-container">
                <p style="margin: 0; font-size: 18px; font-weight: bold; color: #333;">📱 Your QR Code Ticket</p>
                <p style="margin: 5px 0 15px; font-size: 14px; color: #666;">Show this at the entrance</p>
                
                @if($booking->qr_code)
                    <img src="data:image/png;base64,{{ $booking->qr_code }}" 
                         alt="QR Code for {{ $ticketNumber }}" 
                         class="qr-code-img">
                @else
                    <div style="padding: 20px; background: #e9ecef; border-radius: 8px;">
                        <p style="margin: 0; font-size: 16px; color: #495057;">
                            Please use your ticket number for entry
                        </p>
                    </div>
                @endif
                
                <p style="margin: 15px 0 0; font-size: 14px; color: #666;">
                    <strong>Ticket:</strong> {{ $ticketNumber }}
                </p>
            </div>

            <!-- Important Information -->
            <div class="important-info">
                <h4 style="margin: 0 0 10px; color: #856404;">⚠️ Important Information</h4>
                <ul style="margin: 0; padding-left: 20px;">
                    <li>Please arrive 30 minutes before the event starts</li>
                    <li>Bring a valid ID for verification</li>
                    <li>Show this email or QR code at the entrance</li>
                    <li>This ticket is valid for {{ $booking->group_size }} {{ $booking->group_size > 1 ? 'people' : 'person' }}</li>
                    <li>Each ticket can only be verified once at entry</li>
                </ul>
            </div>

            <!-- Contact Support -->
            <div style="text-align: center; margin: 30px 0;">
                <p>Need help? Contact us:</p>
                <p style="margin: 5px 0;">
                    📧 <a href="mailto:support@tikoikoon.com" style="color: #FF2E63;">support@tikoikoon.com</a><br>
                    📱 <a href="tel:+254700000000" style="color: #08D9D6;">+254 700 000 000</a>
                </p>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Visit Our Website</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">🎆 <strong>Tiko Iko On</strong> - Where Vibes Come Alive</p>
            <p style="margin: 10px 0 0; font-size: 12px;">
                © {{ date('Y') }} Tiko Iko On. All rights reserved.<br>
                Meru, Kenya
            </p>
        </div>
    </div>
</body>
</html>