<?php

namespace App\Listeners;

use App\Models\Transaction;
use App\Events\TransactionCreated;

class TransationListener
{
    public function handle(TransactionCreated $event): void
    {
        $today = date('Ymd');
        $transactionsToday = Transaction::where('transaction_no', 'like', "{$today}%")->pluck('transaction_no');
        
        do {
            $transactionNo = $today . rand(10000, 99999);
        } while ($transactionsToday->contains($transactionNo));
        
        $event->transaction->transaction_no = $transactionNo;
    }
}
