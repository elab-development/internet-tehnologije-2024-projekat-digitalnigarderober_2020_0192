<?php

namespace Database\Seeders;

use App\Models\Odeca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OdecaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Odeca::factory()->count(50)->create(); // Kreiranje 50 odeće
    }
}
