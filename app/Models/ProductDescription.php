<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *
 */
class ProductDescription extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_descriptions';

    /**
     * @var string[]
     */
    protected $fillable =
        [
            'product_id',
            'title',
            'meta_keywords',
            'description',
            'short_description',
            'image',
            'images',
        ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
