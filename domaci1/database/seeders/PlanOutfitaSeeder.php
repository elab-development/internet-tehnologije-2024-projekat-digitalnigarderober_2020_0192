<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PlanOutfita;

class PlanOutfitaSeeder extends Seeder
{
    public function run()
    {
        $users = User::all(); // Dohvati sve korisnike

        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) { // Kreiraj 5 planova po korisniku
                PlanOutfita::create([
                    'naziv' => fake()->sentence(3),
                    'datum' => fake()->dateTimeBetween('now', '+1 year'),
                    'lokacija' => fake()->city(),
                    'vremenska_prognoza' => fake()->randomElement([
                        'Sunny', 'Cloudy', 'Rainy', 'Snowy', 'Windy', 'Foggy'
                    ]),
                    'dogadjaj' => fake()->randomElement([
                        'Wedding', 'Casual Meeting', 'Birthday Party', 'Job Interview', 'Outdoor Hike', 'Beach Day'
                    ]),
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
