<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *
 */
class CartProduct extends Model
{
    /**
     * @var string
     */
    protected $table = 'cart_products';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'cart_id',
            'product_id',
            'quantity',
        ];

    /**
     * @return BelongsTo
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
