<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
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
            'title' => fake()->sentence(4),
            'message' => fake()->paragraph(),
            'channels' => fake()->randomElements(['app', 'email', 'sms'], fake()->numberBetween(1, 3)),
            'target_audience' => [
                'type' => fake()->randomElement(['all', 'segment', 'specific']),
                'criteria' => fake()->randomElement(['active_customers', 'vip_customers', 'inactive_customers']),
            ],
            'status' => fake()->randomElement(['draft', 'scheduled', 'sent', 'failed']),
            'scheduled_at' => fake()->optional(0.3)->dateTimeBetween('now', '+7 days'),
            'sent_at' => fake()->optional(0.6)->dateTimeBetween('-30 days', 'now'),
            'sent_count' => fake()->numberBetween(0, 1000),
            'opened_count' => fake()->numberBetween(0, 500),
            'clicked_count' => fake()->numberBetween(0, 100),
            'created_by' => User::factory(),
        ];
    }
}