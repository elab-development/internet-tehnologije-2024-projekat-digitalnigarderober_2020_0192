<?php

namespace Database\Seeders;

use App\Models\Garderober;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GarderoberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Garderober::factory()->count(15)->create();
    }
}
