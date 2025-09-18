<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Received - Tiko Iko On</title>
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
        
        .header .emoji {
            font-size: 40px;
            margin-bottom: 10px;
            display: block;
        }
        
        .content {
            padding: 30px;
        }
        
        .booking-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        
        .detail-value {
            color: #212529;
        }
        
        .price {
            font-size: 24px;
            font-weight: bold;
            color: #FF2E63;
        }
        
        .message-box {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        
        .cta-button {
            display: inline-block;
            background: #FF2E63;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            background: #e0275a;
            transform: translateY(-2px);
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
        }
        
        .footer a {
            color: #FF2E63;
            text-decoration: none;
        }
        
        .members-list {
            margin-top: 15px;
        }
        
        .member-item {
            background: white;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        
        .steps-list {
            background: #e8f5e8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #10b981;
        }
        
        .steps-list ol {
            margin: 0;
            padding-left: 20px;
        }
        
        .steps-list li {
            margin-bottom: 10px;
            color: #047857;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 0;
            }
            
            .content {
                padding: 20px;
            }
            
            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <span class="emoji">🎉</span>
            <h1>Booking Received!</h1>
            <p>We've got your party request - Let's make it epic!</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hi <strong>{{ $booking->team_lead_name }}</strong>,</p>

            <p>Thank you for choosing <strong>Tiko Iko On</strong> for your ultimate party experience! 🔥</p>

            <div class="message-box">
                <h3 style="margin: 0 0 10px 0;">📋 Booking Confirmed</h3>
                <p style="margin: 0;">Your booking has been received successfully. Now complete your payment to secure your tickets!</p>
            </div>

            <!-- Booking Details -->
            <div class="booking-details">
                <h4 style="margin: 0 0 15px 0; color: #FF2E63;">🎫 Your Booking Details</h4>
                
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">#{{ $booking->id }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Plan Type:</span>
                    <span class="detail-value">
                        @if($booking->plan_type === 'IP')
                            🎵 IP - Essential Vibes
                        @elseif($booking->plan_type === 'VIP')
                            ⭐ VIP - Premium Experience
                        @else
                            💎 VVIP - Luxury Lifestyle
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Group Size:</span>
                    <span class="detail-value">{{ $booking->group_size }} {{ $booking->group_size == 1 ? 'person' : 'people' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Contact Phone:</span>
                    <span class="detail-value">{{ $booking->team_lead_phone }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value price">KSH {{ number_format($booking->price) }}</span>
                </div>
            </div>

            <!-- Team Members -->
            @if($booking->members && count($booking->members) > 0)
                <h4>👥 Your Team Members:</h4>
                <div class="members-list">
                    @foreach($booking->members as $index => $member)
                        <div class="member-item">
                            <strong>{{ $member['name'] }}</strong> - {{ $member['email'] }}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Next Steps -->
            <div class="steps-list">
                <h4 style="margin: 0 0 15px 0; color: #059669;">🚀 What's Next?</h4>
                <ol>
                    <li><strong>Complete Payment:</strong> Use the M-Pesa details provided during booking</li>
                    <li><strong>Submit M-Pesa Code:</strong> Enter your confirmation code on the payment page</li>
                    <li><strong>Wait for Confirmation:</strong> Our team will verify and confirm your payment</li>
                    <li><strong>Get Ready to Party:</strong> You'll receive your ticket confirmation via email</li>
                </ol>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p><strong>💳 Payment Details</strong></p>
                <p>M-Pesa Till Number: <strong>123456</strong><br>
                Amount: <strong>KSH {{ number_format($booking->price) }}</strong></p>
                
                <a href="{{ route('payment', $booking) }}" class="cta-button">
                    Complete Payment Now
                </a>
            </div>

            <div style="background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #fbbf24;">
                <h4 style="margin: 0 0 10px 0; color: #856404;">⚠️ Important:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #856404;">
                    <li>Your booking is reserved for 24 hours pending payment</li>
                    <li>Complete payment as soon as possible to secure your tickets</li>
                    <li>Contact us immediately if you face any payment issues</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>🎆 Tiko Iko On</strong><br>
            Where Vibes Come Alive</p>
            
            <p>
                📧 <a href="mailto:hello@tikoikoon.com">hello@tikoikoon.com</a> | 
                📞 +254 700 000 000
            </p>
            
            <p style="font-size: 12px; color: #adb5bd; margin-top: 15px;">
                This email was sent regarding your booking #{{ $booking->id }}. 
                If you didn't make this booking, please contact us immediately.
            </p>
        </div>
    </div>
</body>
</html>
