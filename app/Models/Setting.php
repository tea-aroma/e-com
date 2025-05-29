<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 *
 */
class Setting extends Model
{
    /**
     * @var string
     */
    protected $table = 'settings';

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
