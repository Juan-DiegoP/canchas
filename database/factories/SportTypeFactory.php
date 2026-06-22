<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SportTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Fútbol', 'Baloncesto', 'Tenis', 'Voleibol', 'Pádel']),
            'icon' => 'sport-icon.png',
        ];
    }
}