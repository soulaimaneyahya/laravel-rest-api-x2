<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => fake()->words($nb = 2, true),
            'description' => fake()->sentences($nb = 3, true),
            'created_at' => fake()->dateTimeBetween('-3 weeks'),
            'updated_at' => fake()->dateTimeBetween('-3 weeks'),
        ];
    }
}
