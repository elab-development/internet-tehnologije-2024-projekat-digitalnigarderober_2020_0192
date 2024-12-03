<?php

namespace Database\Factories;

use App\Models\Garderober;
use App\Models\Odeca;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Odeca>
 */
class OdecaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Odeca::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'naziv' => fake()->word(), // Nasumičan naziv odeće
            'tip' => fake()->randomElement([
                'Shirt', 'Pants', 'Dress', 'Skirt', 'Jacket', 'Sweater', 'Shoes'
            ]), // Tip odeće
            'boja' => fake()->safeColorName(), // Nasumična boja
            'sezona' => fake()->randomElement(['Spring', 'Summer', 'Fall', 'Winter']), // Sezona
            'materijal' => fake()->randomElement(['Cotton', 'Polyester', 'Wool', 'Silk', 'Denim', 'Leather']), // Materijal odeće
            'slika' => fake()->imageUrl(400, 400, 'fashion', true, 'Clothing'), // URL slike
            'garderober_id' => Garderober::inRandomOrder()->first()->id ?? Garderober::factory(), // Nasumičan garderober ili novi
        ];
    }
}
