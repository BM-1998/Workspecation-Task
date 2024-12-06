<?php 

namespace Database\Factories;

use App\Models\TutorProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorProductFactory extends Factory
{
    protected $model = TutorProduct::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
        ];
    }
}
