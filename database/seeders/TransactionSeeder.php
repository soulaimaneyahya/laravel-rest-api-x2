<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = max((int)$this->command->ask("How many transactions would you like ?", 100), 0);
        if ($count > 0) {
            $transactions = \App\Models\Transaction::factory($count)->make()->each(function ($transaction) {
                // You requested 1 items, but there are only 0 items available. // should has products, SellerScope
                $seller = \App\Models\Seller::all()->random();
                $buyer = \App\Models\User::all()->except($seller->id)->random();
                $transaction->buyer_id = $buyer->id;
                $transaction->product_id = $seller->products->random()->id;
                $transaction->save();
            });
        }
    }
}
