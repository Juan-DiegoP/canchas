<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $fields = Field::all();

        foreach ($fields as $field) {
            for ($i = 0; $i < 3; $i++) {
                $start = rand(8, 19);
                $end = $start + 1;

                Reservation::create([
                    'field_id' => $field->id,
                    'user_id' => $customers->random()->id,
                    'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
                    'date' => now()->addDays(rand(1, 14))->format('Y-m-d'),
                    'start_time' => sprintf('%02d:00:00', $start),
                    'end_time' => sprintf('%02d:00:00', $end),
                    'total_price' => $field->price_per_hour * ($end - $start),
                    'notes' => null,
                ]);
            }
        }
    }
}