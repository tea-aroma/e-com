<?php

namespace App\Data\Orders;


use App\Standards\Data\Interfaces\OptionsInterface;


/**
 * @inheritDoc
 */
class OrderDataOptions extends OrderData implements OptionsInterface
{
    /**
     * @var string
     */
    public string $order = 'id|desc';
}
