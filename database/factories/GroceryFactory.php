<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class groceryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->company();
        $slug = Str::slug($name);
        return [
            'name' => 'Demo store',
            'slug' => 'demo-store',
            'email' => $this->faker->email(),
            'phone' => $this->faker->e164PhoneNumber(),
            'address' => $this->faker->address(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'uuid' => $this->faker->unique()->uuid(),
            'postal_code' => $this->faker->postcode(),
            'user_id' => $this->faker->unique()->numberBetween(1,50),
            'banner' => '/images/banner',
            'logo' => '/images/installer/spot.png'
        ];
    }
}
