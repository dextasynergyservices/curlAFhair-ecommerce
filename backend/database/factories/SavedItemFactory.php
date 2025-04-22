<?php

namespace Database\Factories;

use App\Models\SavedItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SavedItem>
 */
class SavedItemFactory extends Factory
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
            'item_name' => $this->faker->words(3, true),
            'item_sku' => $this->faker->words(3, true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
