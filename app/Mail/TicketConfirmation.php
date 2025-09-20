<?php
// app/Mail/TicketConfirmation.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class TicketConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $event;
    public $package;
    public $ticketNumber;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->event = $booking->event;
        $this->package = $booking->package;
        $this->ticketNumber = $booking->ticket_number;

        // Generate QR code if not exists
        if (!$booking->qr_code) {
            $booking->generateQRCode();
        }
    }

    public function build()
    {
        return $this->subject('Your Ticket for ' . $this->event->name . ' - ' . $this->ticketNumber)
                    ->view('emails.ticket-confirmation');
    }
}