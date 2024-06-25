<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{OrderSku, Order, Sku};

/**
 * @extends Factory<OrderSku>
 */
class OrderSkuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'sku_id' => Sku::factory(),
            'quantity' => $this->faker->randomDigit(),
        ];
    }
}
