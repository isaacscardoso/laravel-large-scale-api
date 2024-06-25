<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Product, Brand, Category};

/**
 * @extends Factory<Product>
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
        return [
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(1000),
            'is_featured' => $this->faker->boolean(),
        ];
    }
}
