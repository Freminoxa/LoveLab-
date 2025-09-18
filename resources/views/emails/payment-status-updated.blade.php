<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status Update - Tiko Iko On</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #FF2E63, #08D9D6);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 900;
        }
        
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
            margin: 10px 0;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .status-failed {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .booking-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .booking-details h3 {
            margin-top: 0;
            color: #FF2E63;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        
        .detail-value {
            color: #212529;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #08D9D6;
            text-decoration: none;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .content, .header, .footer {
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
            <h1>🎆 Tiko Iko On</h1>
            <p>Where Vibes Come Alive</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <h2>Payment Status Update</h2>
            
            <p>Hi <strong>{{ $booking->team_lead_name }}</strong>,</p>
            
            @if($newStatus === 'confirmed')
                <p>🎉 <strong>Great news!</strong> Your payment has been confirmed and your tickets are ready!</p>
                
                <p>Get ready for an unforgettable party experience! Your {{ $booking->plan_type }} tickets for {{ $booking->group_size }} {{ $booking->group_size == 1 ? 'person' : 'people' }} are now confirmed.</p>
                
                <div style="text-align: center; margin: 30px 0;">
                    <span class="status-badge status-confirmed">✅ Payment Confirmed</span>
                </div>
                
            @elseif($newStatus === 'pending')
                <p>⏳ Your payment is currently being processed. We'll update you once it's confirmed.</p>
                
                <div style="text-align: center; margin: 30px 0;">
                    <span class="status-badge status-pending">⏳ Payment Pending</span>
                </div>
                
            @elseif($newStatus === 'failed')
                <p>❌ We encountered an issue with your payment. Please contact our support team for assistance.</p>
                
                <div style="text-align: center; margin: 30px 0;">
                    <span class="status-badge status-failed">❌ Payment Failed</span>
                </div>
                
            @endif
            
            <!-- Booking Details -->
            <div class="booking-details">
                <h3>📋 Booking Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">#{{ $booking->id }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Plan Type:</span>
                    <span class="detail-value">{{ $booking->plan_type }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Group Size:</span>
                    <span class="detail-value">{{ $booking->group_size }} {{ $booking->group_size == 1 ? 'person' : 'people' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value"><strong>KSH {{ number_format($booking->price) }}</strong></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">{{ ucfirst($newStatus) }}</span>
                </div>
                
                @if($booking->mpesa_code)
                <div class="detail-row">
                    <span class="detail-label">M-Pesa Code:</span>
                    <span class="detail-value">{{ $booking->mpesa_code }}</span>
                </div>
                @endif
            </div>
            
            @if($newStatus === 'confirmed')
                <div style="text-align: center;">
                    <p><strong>What's next?</strong></p>
                    <p>• Save this email as your ticket confirmation<br>
                    • Check your email for event details closer to the date<br>
                    • Follow us on social media for updates</p>
                </div>
            @elseif($newStatus === 'failed')
                <div style="text-align: center;">
                    <p><strong>Need Help?</strong></p>
                    <p>Contact our support team:<br>
                    📞 +254 700 000 000<br>
                    📧 support@tikoikoon.com</p>
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="social-links">
                <a href="#">📱 Instagram</a>
                <a href="#">🎵 TikTok</a>
                <a href="#">🐦 Twitter</a>
                <a href="#">📘 Facebook</a>
            </div>
            
            <p>© {{ date('Y') }} Tiko Iko On. All rights reserved.</p>
            <p>Creating unforgettable party experiences for the next generation.</p>
            
            <p style="font-size: 12px; margin-top: 20px;">
                This email was sent to {{ $booking->team_lead_email }} regarding booking #{{ $booking->id }}.
            </p>
        </div>
    </div>
</body>
</html>
