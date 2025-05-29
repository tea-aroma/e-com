<?php

namespace App\Data\CartProducts;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class ViewCartProductData extends Data
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
     * @var string
     */
    public string $quantity;

    /**
     * @var int
     */
    public int $category_id;

    /**
     * @var string
     */
    public string $category_name;

    /**
     * @var int
     */
    public int $brand_id;

    /**
     * @var string
     */
    public string $brand_name;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $slug;

    /**
     * @var int
     */
    public int $price;

    /**
     * @var int
     */
    public int $discount;

    /**
     * @var string
     */
    public string $sku;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;
}
