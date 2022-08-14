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
    {   $names = ['Burger', 'Pizza', 'Chicken', 'Sandwich', 'Taco', 'Pastry', 'Cake', 'Pancake', 'Fruit Salad', 'Beef'];
        $subNames = ['Royal', 'Special', 'Delight', 'Delicious'];
        return [
            'name' => $this->faker->randomElement($subNames) . ' ' . $this->faker->randomElement($names),
            'description' => $this->faker->text(25),
            'price' => $this->faker->numberBetween(10, 99) * 100,
            'category_id' => $this->faker->numberBetween(1,3),
            'image_path' => '/images/products/' . $this->faker->numberBetween(1,6)
        ];
    }
}
