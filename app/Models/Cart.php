<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 *
 */
class Cart extends Model
{
    /**
     * @var string
     */
    protected $table = 'carts';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'user_id',
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
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(CartProduct::class);
    }
}
