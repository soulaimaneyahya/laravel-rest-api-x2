<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends User
{
    use HasFactory, HasUuids;

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public static function boot()
    {
        static::addGlobalScope(new BuyerScope);
        Parent::boot();
    }
}
