<?php

namespace App\Data\Products;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class ProductData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $category_id;

    /**
     * @var int
     */
    public int $brand_id;

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
    public int $quantity;

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
    public string $description;

    /**
     * @var bool
     */
    public bool $is_active;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;
}
