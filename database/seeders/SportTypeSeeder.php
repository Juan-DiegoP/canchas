<?php

namespace Database\Seeders;

use App\Models\SportType;
use Illuminate\Database\Seeder;

class SportTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Fútbol', 'icon' => 'futbol.png'],
            ['name' => 'Baloncesto', 'icon' => 'baloncesto.png'],
            ['name' => 'Tenis', 'icon' => 'tenis.png'],
            ['name' => 'Voleibol', 'icon' => 'voleibol.png'],
            ['name' => 'Pádel', 'icon' => 'padel.png'],
        ];

        foreach ($types as $type) {
            SportType::create($type);
        }
    }
}