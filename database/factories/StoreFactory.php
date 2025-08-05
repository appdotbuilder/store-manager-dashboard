<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company();
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'phone' => fake()->phoneNumber(),
            'whatsapp' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'website' => fake()->url(),
            'address' => fake()->address(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'business_hours' => [
                'monday' => ['open' => '09:00', 'close' => '18:00'],
                'tuesday' => ['open' => '09:00', 'close' => '18:00'],
                'wednesday' => ['open' => '09:00', 'close' => '18:00'],
                'thursday' => ['open' => '09:00', 'close' => '18:00'],
                'friday' => ['open' => '09:00', 'close' => '18:00'],
                'saturday' => ['open' => '10:00', 'close' => '16:00'],
                'sunday' => ['open' => '10:00', 'close' => '16:00'],
            ],
            'delivery_areas' => [
                ['name' => 'Zone 1', 'fee' => 5.00],
                ['name' => 'Zone 2', 'fee' => 8.00],
                ['name' => 'Zone 3', 'fee' => 12.00],
            ],
            'default_delivery_fee' => fake()->randomFloat(2, 5, 15),
            'currency' => fake()->randomElement(['USD', 'EUR', 'GBP']),
            'timezone' => fake()->timezone(),
            'theme' => 'light',
            'vat_percentage' => fake()->randomFloat(2, 0, 25),
            'payment_methods' => [
                'cod' => ['enabled' => true, 'name' => 'Cash on Delivery'],
                'bank_transfer' => ['enabled' => true, 'name' => 'Bank Transfer'],
                'credit_card' => ['enabled' => false, 'name' => 'Credit Card'],
            ],
            'settings' => [
                'coupons_enabled' => true,
                'wishlists_enabled' => true,
                'reviews_enabled' => true,
                'min_order_amount' => 25.00,
            ],
            'is_active' => true,
        ];
    }
}