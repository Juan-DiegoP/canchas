<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        $venues = [
            [
                'name' => 'Complejo Deportivo La Floresta',
                'address' => 'Cra 76 #45-30',
                'city' => 'Medellín',
                'description' => 'Complejo deportivo con canchas sintéticas y techadas, ubicado en el barrio La Floresta.',
                'phone' => '3001234567',
            ],
            [
                'name' => 'Polideportivo Envigado',
                'address' => 'Cl 38 Sur #43-20',
                'city' => 'Envigado',
                'description' => 'Espacio deportivo municipal con canchas de fútbol, baloncesto y tenis.',
                'phone' => '3012345678',
            ],
            [
                'name' => 'Club Deportivo Sabaneta',
                'address' => 'Cra 45 #75 Sur-10',
                'city' => 'Sabaneta',
                'description' => 'Canchas de césped sintético para fútbol 5 y fútbol 8.',
                'phone' => '3023456789',
            ],
            [
                'name' => 'Centro Deportivo Itagüí',
                'address' => 'Cl 51 #48-90',
                'city' => 'Itagüí',
                'description' => 'Canchas múltiples con iluminación nocturna.',
                'phone' => '3034567890',
            ],
            [
                'name' => 'Unidad Deportiva Belén',
                'address' => 'Cra 76A #1-50',
                'city' => 'Medellín',
                'description' => 'Unidad deportiva con canchas de baloncesto, voleibol y fútbol.',
                'phone' => '3045678901',
            ],
        ];

        foreach ($venues as $venue) {
            Venue::create(array_merge($venue, ['active' => true]));
        }
    }
}