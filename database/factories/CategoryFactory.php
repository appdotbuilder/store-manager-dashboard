<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(2, true);
        
        return [
            'store_id' => Store::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(1, 100),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the category is a subcategory.
     */
    public function subcategory(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => \App\Models\Category::factory(),
        ]);
    }
}