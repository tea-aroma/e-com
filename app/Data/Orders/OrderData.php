<?php

namespace App\Data\Orders;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class OrderData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var int
     */
    public int $user_id;

    /**
     * @var int
     */
    public int $payment_method_id;

    /**
     * @var string
     */
    public string $payment_method_name;

    /**
     * @var int
     */
    public int $payment_address_id;

    /**
     * @var string
     */
    public string $payment_address_name;

    /**
     * @var int
     */
    public int $shipping_status_id;

    /**
     * @var string
     */
    public string $shipping_status_name;

    /**
     * @var int
     */
    public int $shipping_method_id;

    /**
     * @var string
     */
    public string $shipping_method_name;

    /**
     * @var int
     */
    public int $shipping_address_id;

    /**
     * @var string
     */
    public string $shipping_address_name;

    /**
     * @var string
     */
    public string $notes;

    /**
     * @var string
     */
    public string $discount_code;

    /**
     * @var int
     */
    public int $total;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;
}
