<?php

namespace App\Jobs;

use App\Mail\EventAttendeesBroadcast;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEventAttendeesBroadcastChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 180;

    public function __construct(
        public int $eventId,
        public string $subjectLine,
        public string $mainMessage,
        public string $promoMessage,
        public string $supplementalMessage,
        public array $recipients
    ) {
    }

    public function handle(): void
    {
        $event = Event::find($this->eventId);
        if (!$event) {
            Log::warning('Event email broadcast chunk skipped: event not found', [
                'event_id' => $this->eventId,
            ]);
            return;
        }

        foreach ($this->recipients as $email) {
            try {
                Mail::to($email)->send(new EventAttendeesBroadcast(
                    $event,
                    $this->subjectLine,
                    $this->mainMessage,
                    $this->promoMessage,
                    $this->supplementalMessage
                ));
            } catch (\Throwable $e) {
                Log::error('Failed to send attendee broadcast email from queued chunk', [
                    'event_id' => $this->eventId,
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Email broadcast chunk job failed', [
            'event_id' => $this->eventId,
            'recipient_count' => count($this->recipients),
            'error' => $exception->getMessage(),
        ]);
    }
}

