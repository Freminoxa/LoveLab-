<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AttendanceConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $recipientEmail;
    public string $recipientName;

    public function __construct(Booking $booking, string $recipientEmail, string $recipientName = 'Participant')
    {
        $this->booking = $booking;
        $this->recipientEmail = $recipientEmail;
        $this->recipientName = $recipientName;
    }

    public function build(): self
    {
        return $this->subject('Attendance Confirmed - ' . $this->booking->event->name)
            ->view('emails.attendance-confirmed');
    }
}
