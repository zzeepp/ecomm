<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
             'name' => $this->faker->name,
			  'description' => $this->faker->realText(100),
			  'parent_id' => 1,
			  'menu' => 1,
        ];
    }
}
