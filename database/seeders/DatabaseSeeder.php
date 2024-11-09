<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        if ($this->command->confirm('Do you want to refresh the DB?')) {
            $this->command->call('migrate:fresh');
            $this->command->info('---------------------------------- database refreshed');
        }

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            TransactionSeeder::class
        ]);

        $this->command->info("---------------------------------- thanks seeder");

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
