<?php

namespace App\Data\CartProducts;


use App\Standards\Data\Interfaces\OptionsInterface;


/**
 * @inheritDoc
 */
class CartProductDataOptions extends CartProductData implements OptionsInterface
{
    /**
     * @var string
     */
    public string $order = 'id|desc';
}
