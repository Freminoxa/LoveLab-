<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketConfirmation;
use App\Models\Booking;

class TestEmail extends Command
{
    protected $signature = 'mail:test {email}';
    protected $description = 'Test email configuration by sending a test email';

    public function handle()
    {
        $email = $this->argument('email');
        
        try {
            // Get a sample booking for testing
            $booking = Booking::first();
            
            if (!$booking) {
                $this->error('No bookings found in database to use for testing.');
                return 1;
            }
            
            $this->info("Sending test email to: {$email}");
            $this->info("Using booking ID: {$booking->id}");
            
            Mail::to($email)->send(new TicketConfirmation($booking));
            
            $this->info("✅ Test email sent successfully!");
            return 0;
            
        } catch (\Exception $e) {
            $this->error("❌ Failed to send email: " . $e->getMessage());
            return 1;
        }
    }
}
