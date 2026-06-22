<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\SportType;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        $sportTypes = SportType::all();

        Venue::all()->each(function (Venue $venue) use ($sportTypes) {
            for ($i = 0; $i < rand(2, 4); $i++) {
                Field::factory()->create([
                    'venue_id' => $venue->id,
                    'sport_type_id' => $sportTypes->random()->id,
                ]);
            }
        });
    }
}