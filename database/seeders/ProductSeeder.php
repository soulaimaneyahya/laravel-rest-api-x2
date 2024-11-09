<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = max((int)$this->command->ask("How many products would you like ?", 20), 0);
        if ($count > 0) {
            Product::factory($count)->create();

            Product::all()->each(function (Product $product) {
                $take = random_int(1, 3);
                $categories = \App\Models\Category::inRandomOrder()->take($take)->get()->pluck('id');
                $product->categories()->syncWithoutDetaching($categories);
            });
        }
    }
}
