<?php

namespace App\Data\OrderProducts;


use App\Standards\Data\Interfaces\OptionsInterface;


/**
 * @inheritDoc
 */
class OrderProductDataOptions extends OrderProductData implements OptionsInterface
{
    /**
     * @var string
     */
    public string $order = 'id|desc';
}
