<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class TicketConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $ticketNumber;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->ticketNumber = $this->generateTicketNumber($booking);
    }

    /**
     * Generate unique ticket number
     */
    private function generateTicketNumber($booking)
    {
        return 'TKO-' . strtoupper(substr($booking->event->name, 0, 3)) . '-' . 
               date('Ymd') . '-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🎉 Your Ticket for ' . $this->booking->event->name)
                    ->view('emails.ticket-confirmation')
                    ->with([
                        'booking' => $this->booking,
                        'ticketNumber' => $this->ticketNumber,
                        'event' => $this->booking->event,
                        'package' => $this->booking->package,
                    ]);
    }
}