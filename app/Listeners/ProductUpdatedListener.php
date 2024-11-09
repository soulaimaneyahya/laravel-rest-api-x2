<?php

namespace App\Listeners;

use App\Models\Product;
use App\Events\ProductUpdated;

class ProductUpdatedListener
{
    /**
     * Handle the event.
     */
    public function handle(ProductUpdated $event): void
    {
        if ($event->product->quantity == 0 && $event->product->isAvailable()) {
            $event->product->update([
                'status' => Product::UNAVAILABLE_PRODUCT
            ]);
        }
    }
}
