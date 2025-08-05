<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_id' => Store::factory(),
            'name' => fake()->name(),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'date_of_birth' => fake()->optional()->dateTimeBetween('-60 years', '-18 years'),
            'gender' => fake()->optional()->randomElement(['male', 'female', 'other']),
            'is_active' => true,
            'total_spent' => fake()->randomFloat(2, 0, 5000),
            'total_orders' => fake()->numberBetween(0, 50),
            'last_order_at' => fake()->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}