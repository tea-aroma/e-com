<?php

namespace App\Data\Carts;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class CartData extends Data
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
