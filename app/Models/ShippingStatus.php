<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 *
 */
class ShippingStatus extends Model
{
    /**
     * @var string
     */
    protected $table = 'shipping_statuses';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'name',
            'code',
            'description',
            'sort_order',
            'is_active',
        ];
}
