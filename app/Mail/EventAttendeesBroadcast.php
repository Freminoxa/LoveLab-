<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventAttendeesBroadcast extends Mailable
{
    use Queueable, SerializesModels;

    public Event $event;
    public string $mainMessage;
    public string $promoMessage;
    public string $supplementalMessage;
    protected string $subjectLine;

    public function __construct(
        Event $event,
        string $subjectLine,
        string $mainMessage,
        string $promoMessage = '',
        string $supplementalMessage = ''
    )
    {
        $this->event = $event;
        $this->subjectLine = $subjectLine;
        $this->mainMessage = $mainMessage;
        $this->promoMessage = $promoMessage;
        $this->supplementalMessage = $supplementalMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-attendee-broadcast',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
