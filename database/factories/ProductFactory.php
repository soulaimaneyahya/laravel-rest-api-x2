<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => fake()->words($nb = 2, true),
            'description' => fake()->sentences($nb = 3, true),
            'quantity' => fake()->numberBetween(1, 10),
            'price' => fake()->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
            \App\Models\Product::STATUS => fake()->randomElement([\App\Models\Product::AVAILABLE_PRODUCT, \App\Models\Product::UNAVAILABLE_PRODUCT]),
            'image' => fake()->randomElement(['1.jpeg', '2.jpeg', '3.jpeg', '4.jpeg']),
            'seller_id' => \App\Models\User::all()->random()->id,
            'created_at' => fake()->dateTimeBetween('-3 weeks'),
            'updated_at' => fake()->dateTimeBetween('-3 weeks'),
        ];
    }
}
