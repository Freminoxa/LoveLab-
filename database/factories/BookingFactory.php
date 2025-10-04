<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Package;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'package_id' => Package::factory(),
            'plan_type' => 'Standard',
            'group_size' => 1,
            'price' => 500.00,
            'team_lead_name' => $this->faker->name,
            'team_lead_email' => $this->faker->safeEmail,
            'team_lead_phone' => $this->faker->phoneNumber,
            'members' => null,
            'payment_status' => 'confirmed',
            'mpesa_code' => 'MPESA12345',
            'qr_code' => null,
            'confirmed_by_manager' => true,
            'is_verified' => false,
            'verification_count' => 0,
        ];
    }
}
