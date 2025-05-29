<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *
 */
class ShippingAddress extends Model
{
    /**
     * @var string
     */
    protected $table = 'shipping_addresses';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'user_id',
            'name',
            'code',
            'description',
            'sort_order',
            'is_active',
        ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
