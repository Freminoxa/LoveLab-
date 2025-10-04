<?php

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Manager;

beforeEach(function () {
    // nothing
});

it('allows manager to verify a ticket via manual verification', function () {
    $manager = Manager::factory()->create();
    $event = Event::factory()->create(['manager_id' => $manager->id]);

    $booking = Booking::factory()->create([
        'event_id' => $event->id,
        'payment_status' => 'confirmed',
        'confirmed_by_manager' => true,
        'is_verified' => false,
    ]);

    // Simulate manager session
    session(['manager_id' => $manager->id]);

    $response = $this->post('/manager/manual-verification', [
        'ticket_number' => $booking->ticket_number,
        'event_id' => $event->id,
    ]);

    $response->assertStatus(200);
    $data = $response->json();
    assert($data['success'] === true);
    $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'is_verified' => true]);
});
