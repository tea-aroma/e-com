<?php

namespace App\Data\CartProducts;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class CartProductData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $cart_id;

    /**
     * @var int
     */
    public int $product_id;

    /**
     * @var int
     */
    public int $quantity;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;
}
