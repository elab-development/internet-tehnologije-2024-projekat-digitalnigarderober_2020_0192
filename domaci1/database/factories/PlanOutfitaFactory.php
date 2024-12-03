<?php

namespace Database\Factories;

use App\Models\PlanOutfita;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanOutfita>
 */
class PlanOutfitaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlanOutfita::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'naziv' => fake()->sentence(3), // Nasumičan naziv plana
            'datum' => fake()->dateTimeBetween('now', '+1 year'), // Datum u budućnosti
            'lokacija' => fake()->city(), // Nasumičan grad
            'vremenska_prognoza' => fake()->randomElement([
                'Sunny', 'Cloudy', 'Rainy', 'Snowy', 'Windy', 'Foggy'
            ]), // Nasumična vremenska prognoza
            'dogadjaj' => fake()->randomElement([
                'Wedding', 'Casual Meeting', 'Birthday Party', 'Job Interview', 'Outdoor Hike', 'Beach Day'
            ]), // Nasumičan događaj
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(), // Nasumičan korisnik ili generisanje novog
        ];
    }
}
