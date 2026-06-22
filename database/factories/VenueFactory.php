<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Sports Club',
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'description' => fake()->paragraph(),
            'image' => null,
            'phone' => fake()->phoneNumber(),
            'active' => true,
        ];
    }
}