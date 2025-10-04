<?php

use Tests\TestCase;
use App\Models\Event;

beforeEach(function () {
    // migrations will run because RefreshDatabase is used
});

test('public homepage lists published events', function () {
    Event::factory()->create(['status' => 'published', 'name' => 'Test Event']);
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('Test Event');
});
