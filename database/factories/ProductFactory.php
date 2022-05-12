<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->text(10),
            'description' => $this->faker->text(25),
            'price' => $this->faker->numberBetween(100, 9999),
            'category_id' => $this->faker->numberBetween(1,10)
        ];
    }
}
