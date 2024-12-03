<?php

namespace Database\Factories;

use App\Models\Garderober;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Garderober>
 */
class GarderoberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Garderober::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'naziv' => fake()->word() . ' Garderober', // Nasumičan naziv garderobera
            'opis' => fake()->sentence(10), // Kratak opis garderobera
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(), // Nasumičan korisnik ili novi
        ];
    }
}
