<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 *
 */
class ShippingMethod extends Model
{
    /**
     * @var string
     */
    protected $table = 'shipping_methods';

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
