<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actions = [
            'created product',
            'updated order',
            'deleted customer',
            'logged in',
            'logged out',
            'changed settings',
            'sent notification',
            'processed payment',
        ];
        
        return [
            'store_id' => fake()->optional()->randomElement([1, 2, 3]),
            'user_id' => User::factory(),
            'action' => fake()->randomElement($actions),
            'model_type' => fake()->optional()->randomElement(['Product', 'Order', 'Customer', 'Category']),
            'model_id' => fake()->optional()->numberBetween(1, 100),
            'description' => fake()->sentence(),
            'properties' => [
                'old_values' => ['status' => 'pending'],
                'new_values' => ['status' => 'processing'],
                'ip' => fake()->ipv4(),
            ],
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }
}