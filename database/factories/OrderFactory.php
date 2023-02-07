<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
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
            'order_type' => $this->faker->numberBetween(1,3),
            'customer_name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'customer_phone' => $this->faker->numberBetween(1000000000,9999999999),
            'delivery_fee' => $this->faker->numberBetween(100,250),
            // 'checkout_id' => $this->faker->numberBetween(1,10),
            'grocery_id' => $this->faker->numberBetween(0,4),
            'total' => $this->faker->numberBetween(1000,999999),
        ];
    }
}
