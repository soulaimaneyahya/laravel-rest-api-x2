<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = max((int)$this->command->ask("How many categories would you like ?", 20), 0);
        if ($count > 0) {
            $categories = \App\Models\Category::factory($count)->create();
        }
    }
}
