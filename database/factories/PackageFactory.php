<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Package;
use App\Models\Event;

class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'group_size' => 1,
            'available_tickets' => 100,
            'description' => $this->faker->sentence,
            'icon' => '🎫'
        ];
    }
}
