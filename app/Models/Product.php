<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate(int $int)
 * @method static create(array $data)
 * @property Sku $skus
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'description',
        'is_featured',
    ];

    /**
     * Returns the product with the related brand.
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Returns the product with the related category.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Returns the products with their related skus.
     *
     * @return HasMany
     */
    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }
}
