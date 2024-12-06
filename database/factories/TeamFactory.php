<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\TutorProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'tutor_product_id' => TutorProduct::factory(), 
            'name' => $this->faker->name,
            'contact' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
        ];
    }
}
