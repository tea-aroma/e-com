<?php

namespace App\Data\OrderProducts;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class OrderProductData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $order_id;

    /**
     * @var int
     */
    public int $product_id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $sku;

    /**
     * @var int
     */
    public int $price;

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
