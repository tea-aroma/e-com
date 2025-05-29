<?php

namespace App\Data\ProductDescriptions;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class ProductDescriptionData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $product_id;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $meta_keywords;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var string
     */
    public string $short_description;

    /**
     * @var string|null
     */
    public ?string $image;

    /**
     * @var string
     */
    public string $images;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;
}
