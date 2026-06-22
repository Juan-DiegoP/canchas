<?php

namespace Database\Factories;

use App\Models\SportType;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    public function definition(): array
    {
        return [
            'venue_id' => Venue::factory(),
            'sport_type_id' => SportType::factory(),
            'name' => 'Cancha ' . fake()->numberBetween(1, 10),
            'description' => fake()->sentence(),
            'price_per_hour' => fake()->randomFloat(2, 30000, 120000),
            'capacity' => fake()->numberBetween(2, 22),
            'surface' => fake()->randomElement(['grass', 'synthetic', 'cement']),
            'active' => true,
        ];
    }
}