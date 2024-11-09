<?php

namespace App\Models;

use App\Events\ProductUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    public const TABLE = 'products';
    public const STATUS = 'status';

    public const AVAILABLE_PRODUCT = 'available';
    public const UNAVAILABLE_PRODUCT = 'unavailable';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'image',
        'seller_id',
        self::STATUS
    ];

    protected $hidden = [
        'deleted_at',
        'pivot'
    ];

    /**
     * Disable auto incrementing
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
    ];

    protected $dates = ['deleted_at'];

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getAttribute(self::STATUS);
    }

    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->getStatus() == self::AVAILABLE_PRODUCT;
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id')
            ->withTimestamps()
            ->as('product_category');
    }

    public static function boot()
    {
        parent::boot();

        self::updated(function(self $product){
            Event::dispatch(new ProductUpdated($product));
        });
    }
}
