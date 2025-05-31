<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 *
 */
class ViewLatestPaymentHistory extends Model
{
    /**
     * @var string
     */
    protected $table = 'v_latest_payment_history';

    /**
     * @var bool
     */
    public $timestamps = false;
}
