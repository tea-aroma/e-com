<?php

namespace App\Data\CartProducts;


use App\Standards\Data\Interfaces\OptionsInterface;


/**
 * @inheritDoc
 */
class ViewCartProductDataOptions extends CartProductData implements OptionsInterface
{
    /**
     * @var string
     */
    public string $order = 'price|desc';
}
