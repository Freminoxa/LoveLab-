<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Update - Tikoikoon</title>
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
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #FF2E63, #08D9D6);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: bold;
        }

        .header p {
            margin: 8px 0 0;
            opacity: 0.95;
            font-size: 15px;
        }

        .content {
            padding: 30px;
        }

        .logo-wrap {
            margin-bottom: 12px;
        }

        .logo {
            width: 76px;
            height: 76px;
            object-fit: contain;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.18);
            padding: 8px;
            display: inline-block;
        }

        .event-chip {
            background: #f8f9fa;
            border-left: 4px solid #FF2E63;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .event-chip strong {
            color: #FF2E63;
        }

        .message-box {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
        }

        .promo-box {
            margin-top: 18px;
            background: #fff6fa;
            border: 1px solid #ffd4e5;
            border-top: 4px solid #FF2E63;
            border-radius: 8px;
            padding: 16px;
        }

        .promo-title {
            margin: 0 0 8px 0;
            color: #FF2E63;
            font-weight: bold;
            font-size: 16px;
        }

        .support-box {
            margin-top: 18px;
            background: #f8f9fa;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
        }

        .cta-wrap {
            text-align: center;
            margin-top: 24px;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #FF2E63, #08D9D6);
            color: #ffffff !important;
            padding: 12px 28px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo-wrap">
                <img src="https://tikoikoon.co.ke/images/logo.png" alt="Tikoikoon Logo" class="logo">
            </div>
            <h1>Message from Tikoikoon Technologies</h1>
            <p>Event Platform: tikoikoon.co.ke</p>
        </div>

        <div class="content">
            <div class="event-chip">
                <strong>{{ $event->name }}</strong><br>
                {{ $event->date->format('l, F j, Y - g:i A') }}<br>
                {{ $event->location }}
            </div>

            <div class="message-box">
                {!! nl2br(e($mainMessage)) !!}
            </div>

            @if(!empty($promoMessage))
                <div class="promo-box">
                    <p class="promo-title">Promotional Opportunity</p>
                    {!! nl2br(e($promoMessage)) !!}
                </div>
            @endif

            @if(!empty($supplementalMessage))
                <div class="support-box">
                    {!! nl2br(e($supplementalMessage)) !!}
                </div>
            @endif

            <div class="cta-wrap">
                <a href="https://tikoikoon.co.ke" class="cta-button">Visit tikoikoon.co.ke</a>
            </div>
        </div>

        <div class="footer">
            Strategic communication from Tikoikoon Technologies on tikoikoon.co.ke
        </div>
    </div>
</body>
</html>
