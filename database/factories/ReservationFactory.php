<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->numberBetween(8, 19);
        $end = $start + 1;

        return [
            'field_id' => Field::factory(),
            'user_id' => User::factory(),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
            'date' => fake()->dateTimeBetween('now', '+2 weeks')->format('Y-m-d'),
            'start_time' => sprintf('%02d:00:00', $start),
            'end_time' => sprintf('%02d:00:00', $end),
            'total_price' => 50000,
            'notes' => null,
        ];
    }
}