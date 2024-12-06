<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TutorProduct;
use App\Models\Team;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call your seeders here
        TutorProduct::factory(10)->create();
        Team::factory(20)->create();
    }
}
