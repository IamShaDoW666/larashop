<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
            'price' => $this->faker->numberBetween(16, 99) * 100,         
        ];
    }
}
