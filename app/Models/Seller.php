<?php

namespace App\Models;

use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends User
{
    use HasFactory, HasUuids;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function boot()
    {
        static::addGlobalScope(new SellerScope);
        Parent::boot();
    }
}
