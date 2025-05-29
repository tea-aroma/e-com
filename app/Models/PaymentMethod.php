<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 *
 */
class PaymentMethod extends Model
{
    /**
     * @var string
     */
    protected $table = 'payment_methods';

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
