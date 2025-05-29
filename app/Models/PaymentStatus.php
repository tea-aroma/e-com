<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 *
 */
class PaymentStatus extends Model
{
    /**
     * @var string
     */
    protected $table = 'payment_statuses';

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
