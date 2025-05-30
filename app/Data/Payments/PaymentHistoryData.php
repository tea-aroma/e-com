<?php

namespace App\Data\Payments;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class PaymentHistoryData extends Data
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
    public int $order_id;

    /**
     * @var int|null
     */
    public ?int $old_payment_status_id;

    /**
     * @var string|null
     */
    public ?string $old_payment_status_name;

    /**
     * @var int
     */
    public int $new_payment_status_id;

    /**
     * @var string
     */
    public string $new_payment_status_name;

    /**
     * @var string
     */
    public string $token;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;
}
