<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *
 */
class OrderProduct extends Model
{
    /**
     * @var string
     */
    protected $table = 'order_products';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'order_id',
            'product_id',
            'name',
            'sku',
            'price',
            'quantity',
        ];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
