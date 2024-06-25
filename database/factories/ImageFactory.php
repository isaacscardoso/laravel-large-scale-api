<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Image, Sku};

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku_id' => Sku::factory(),
            'url' => $this->faker->imageUrl(),
            'is_cover' => $this->faker->boolean(),
        ];
    }
}
