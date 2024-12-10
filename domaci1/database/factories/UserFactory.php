<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ime' => fake()->firstName(),
            'prezime' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'), // generisanje hashovane lozinke
            'avatar' => fake()->imageUrl(200, 200, 'people'), // nasumična slika avatara
            'datum_rodjenja' => fake()->date(),
            'telefon' => fake()->phoneNumber(),
            'adresa' => fake()->address(),
            'biografija' => fake()->text(200), // kratka biografija
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
