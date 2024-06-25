<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class OrderSku extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'sku_id' .
        'quantity',
    ];

    /**
     * Returns the order with the related order sku.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Returns the sku with the related order sku.
     *
     * @return BelongsTo
     */
    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }
}
