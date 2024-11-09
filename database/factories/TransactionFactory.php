<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(1,3),
            'total_price' => fake()->randomFloat($nbMaxDecimals = 4, $min = 0, $max = 5000),
            'created_at' => fake()->dateTimeBetween('-3 weeks'),
            'updated_at' => fake()->dateTimeBetween('-3 weeks'),
        ];
    }
}
