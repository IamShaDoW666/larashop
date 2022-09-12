<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $names = ['FRUITS & VEGETABLES', 'SNACKS & BRANDED FOODS', 'BEVERAGES', 'FOODGRAINS', 'OIL & MASALA'];
        return [
            'name' => $this->faker->unique()->randomElement($names),
            'restorant_id' => 1
        ];
    }
}
