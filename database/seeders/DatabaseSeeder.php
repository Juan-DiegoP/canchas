<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Administrador',
            'email' => 'admin@canchasya.com',
        ]);

        User::factory()->count(10)->create();

        $this->call([
            SportTypeSeeder::class,
            VenueSeeder::class,
            FieldSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}