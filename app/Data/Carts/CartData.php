<?php

namespace App\Data\Carts;


use App\Data\CartProducts\CartProductData;
use App\Data\Users\UserData;
use App\Standards\Data\Abstracts\Data;
use Illuminate\Support\Collection;


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

    /**
     * @return UserData
     */
    public function user(): UserData
    {
        return UserData::fromModel($this->model->user);
    }

    /**
     * @return Collection<CartProductData>
     */
    public function products(): Collection
    {
        return UserData::map($this->model->products);
    }
}
