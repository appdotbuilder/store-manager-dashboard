<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 20, 200);
        $taxAmount = $subtotal * 0.1; // 10% tax
        $deliveryFee = fake()->randomFloat(2, 5, 15);
        $discountAmount = fake()->optional(0.3)->randomFloat(2, 0, $subtotal * 0.2) ?: 0;
        $totalAmount = $subtotal + $taxAmount + $deliveryFee - $discountAmount;
        
        return [
            'store_id' => Store::factory(),
            'order_number' => 'ORD-' . fake()->unique()->numerify('######'),
            'customer_id' => Customer::factory(),
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'completed', 'canceled']),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'delivery_fee' => $deliveryFee,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'payment_method' => fake()->randomElement(['cod', 'bank_transfer', 'credit_card']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'partially_paid', 'refunded', 'failed']),
            'delivery_address' => fake()->address(),
            'delivery_latitude' => fake()->latitude(),
            'delivery_longitude' => fake()->longitude(),
            'delivery_phone' => fake()->phoneNumber(),
            'notes' => fake()->optional()->sentence(),
            'assigned_to' => fake()->optional()->randomElement([1, 2, 3]),
            'delivered_at' => fake()->optional(0.5)->dateTimeBetween('-30 days', 'now'),
        ];
    }
}