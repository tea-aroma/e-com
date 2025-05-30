<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *
 */
class PaymentHistory extends Model
{
    /**
     * @var string
     */
    protected $table = 'payment_history';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'user_id',
            'order_id',
            'old_payment_status_id',
            'old_payment_status_name',
            'new_payment_status_id',
            'new_payment_status_name',
            'token',
        ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
