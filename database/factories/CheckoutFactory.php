<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CheckoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'amount' => $this->faker->numberBetween(2000,50000),
            'user_id' => $this->faker->numberBetween(1,5),
            'order_id' => $this->faker->numberBetween(1,10),
            'processed' => $this->faker->randomElement([true, false])
        ];
    }
}
