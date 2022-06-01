<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->city(),
            'delivery_fee' => $this->faker->numberBetween(100,1000),
            'restorant_id' => $this->faker->numberBetween(1, 3)
        ];
    }
}
