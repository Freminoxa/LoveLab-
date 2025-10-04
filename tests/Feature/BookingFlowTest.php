<?php

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Package;

beforeEach(function () {
    // nothing
});

it('creates a booking and redirects to payment', function () {
    $event = Event::factory()->create(['status' => 'published']);
    $package = Package::factory()->create(['event_id' => $event->id]);

    $payload = [
        'event_id' => $event->id,
        'package_id' => $package->id,
        'team_lead_name' => 'Alice',
        'team_lead_email' => 'alice@example.com',
        'team_lead_phone' => '0712345678',
        'group_size' => 2,
        'price' => 1000,
    ];

    $response = $this->post('/submit-booking', $payload);
    $response->assertRedirect();
    $this->assertDatabaseHas('bookings', ['team_lead_email' => 'alice@example.com']);
});
