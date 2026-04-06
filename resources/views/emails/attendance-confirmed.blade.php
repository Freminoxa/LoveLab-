<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Confirmed</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f5f7fb; margin: 0; padding: 20px; color: #1f2937;">
    <div style="max-width: 620px; margin: 0 auto; background: #ffffff; border-radius: 10px; overflow: hidden; border: 1px solid #e5e7eb;">
        <div style="background: linear-gradient(135deg, #ff2e63, #08d9d6); color: #fff; padding: 20px;">
            <h2 style="margin: 0;">Attendance Confirmed</h2>
        </div>

        <div style="padding: 24px;">
            <p style="margin-top: 0;">Hi {{ $recipientName }},</p>
            <p>Your attendance has been confirmed for <strong>{{ $booking->event->name }}</strong>.</p>

            <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
                <tr>
                    <td style="padding: 8px 0; color: #6b7280;">Event</td>
                    <td style="padding: 8px 0; font-weight: 600;">{{ $booking->event->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280;">Date</td>
                    <td style="padding: 8px 0; font-weight: 600;">{{ $booking->event->date->format('l, F j, Y g:i A') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280;">Venue</td>
                    <td style="padding: 8px 0; font-weight: 600;">{{ $booking->event->location }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #6b7280;">Ticket Number</td>
                    <td style="padding: 8px 0; font-weight: 600;">{{ $booking->ticket_number ?? 'N/A' }}</td>
                </tr>
            </table>

            <p style="margin-bottom: 0;">Thank you for attending.</p>
        </div>
    </div>
</body>
</html>
