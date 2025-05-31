<?php

namespace App\Data\Orders;


use App\Standards\Data\Interfaces\OptionsInterface;


/**
 * @inheritDoc
 */
class ViewOrderDataOptions extends ViewOrderData implements OptionsInterface
{
    /**
     * @var string
     */
    public string $order = 'id|desc';
}
