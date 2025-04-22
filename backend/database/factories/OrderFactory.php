<?php

namespace Database\Factories;

use App\Models\Order;
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
        return [
            'user_id' => \App\Models\User::factory(),
            'order_number' => $this->faker->uuid,
            'status' => 'pending',
            'total' => $this->faker->randomFloat(2, 20, 200),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
