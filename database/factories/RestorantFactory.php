<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RestorantFactory extends Factory
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
            'name' => $name,
            'slug' => $slug,
            'email' => $this->faker->email(),
            'phone' => $this->faker->e164PhoneNumber(),
            'address' => $this->faker->address(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'uuid' => $this->faker->unique()->uuid(),
            'postal_code' => $this->faker->postcode(),
            'user_id' => auth()->user()->id ? auth()->user()->id : $this->faker->unique()->numberBetween(1,50),
        ];
    }
}
