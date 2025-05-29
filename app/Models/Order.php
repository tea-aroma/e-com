<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 *
 */
class Order extends Model
{
    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'user_id',
            'payment_method_id',
            'payment_method_name',
            'payment_status_id',
            'payment_status_name',
            'payment_address_id',
            'payment_address_name',
            'shipping_status_id',
            'shipping_status_name',
            'shipping_method_id',
            'shipping_method_name',
            'shipping_address_id',
            'shipping_address_name',
            'notes',
            'discount_code',
            'total',
        ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
