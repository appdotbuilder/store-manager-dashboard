<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);
        
        return [
            'store_id' => Store::factory(),
            'sku' => fake()->unique()->bothify('SKU-####-????'),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(),
            'images' => [
                'https://via.placeholder.com/400x400/0066cc/ffffff?text=Product+1',
                'https://via.placeholder.com/400x400/0066cc/ffffff?text=Product+2',
            ],
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'stock_quantity' => fake()->numberBetween(0, 100),
            'price' => fake()->randomFloat(2, 10, 500),
            'discount_price' => fake()->optional(0.3)->randomFloat(2, 5, 400),
            'minimum_quantity' => 1,
            'maximum_per_order' => fake()->optional()->numberBetween(5, 20),
            'expiry_date' => fake()->optional(0.2)->dateTimeBetween('now', '+2 years'),
            'is_available' => fake()->boolean(90),
            'is_featured' => fake()->boolean(20),
            'is_visible' => fake()->boolean(95),
            'tags' => fake()->words(5),
            'attributes' => [
                'color' => fake()->colorName(),
                'size' => fake()->randomElement(['Small', 'Medium', 'Large']),
                'weight' => fake()->randomFloat(2, 0.1, 5) . 'kg',
            ],
            'views_count' => fake()->numberBetween(0, 1000),
        ];
    }

    /**
     * Indicate that the product is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the product is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => 0,
            'is_available' => false,
        ]);
    }
}