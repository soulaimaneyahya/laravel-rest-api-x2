<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = max((int)$this->command->ask("How many users would you like ?", 100), 0);
        if ($count > 0) {
            $admin = \App\Models\User::factory()->admin()->create();
            $john = \App\Models\User::factory()->john()->create();
            $users = \App\Models\User::factory($count)->create();
        }
    }
}
