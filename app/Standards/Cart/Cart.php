<?php

namespace App\Standards\Cart;


use App\Data\CartProducts\CartProductData;
use App\Data\CartProducts\CartProductDataAttributes;
use App\Data\CartProducts\ViewCartProductData;
use App\Data\CartProducts\ViewCartProductDataOptions;
use App\Data\Carts\CartData;
use App\Data\Carts\CartDataAttributes;
use App\Data\Orders\OrderData;
use App\Data\Orders\OrderDataOptions;
use App\Http\Requests\Payments\PaymentRequest;
use App\Repositories\CartProducts\CartProductsRepository;
use App\Repositories\CartProducts\ViewCartProductsRepository;
use App\Repositories\Carts\CartRepository;
use App\Repositories\Orders\OrderRepository;
use App\Standards\Payment\Payment;
use Illuminate\Support\Collection;


/**
 * Provides the logic for managing the cart.
 */
class Cart
{
    /**
     * @param int $product_id
     * @param int $quantity
     *
     * @return CartProductData
     */
    public function append(int $product_id, int $quantity): CartProductData
    {
        $record = CartProductsRepository::query()->find($product_id);

        $values = new CartProductDataAttributes([ 'product_id' => $product_id, 'cart_id' => $this->getCartId() ]);

        $attributes = new CartProductDataAttributes($values->toArray());

        $values->quantity = ($record?->quantity ?? 0) +$quantity;

        if ($values->quantity > 0)
        {
            $record = CartProductsRepository::query()->writeOrUpdate($attributes, $values);
        }

        return CartProductData::fromModel($record);
    }

    /**
     * @param int $product_id
     *
     * @return bool
     */
    public function delete(int $product_id): mixed
    {
        return CartProductsRepository::query()->delete($product_id);
    }

    /**
     * @return bool
     */
    public function clear(): mixed
    {
        return CartRepository::query()->delete($this->getCartId());
    }

    /**
     * @return CartData
     */
    public function getCart(): CartData
    {
        $values = CartDataAttributes::fromModel(user()->getModel());

        $attributes = new CartDataAttributes([ 'user_id' => $values->id ]);

        $record = CartRepository::query()->findOrCreate($attributes, $values);

        return CartData::fromModel($record);
    }

    /**
     * @return int
     */
    public function getCartId(): int
    {
        $cart = $this->getCart();

        return $cart->id;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->getProducts()->reduce(function($accumulator, ViewCartProductData $cartData)
        {
            return $accumulator + $cartData->price * $cartData->quantity;
        }, 0);
    }

    /**
     * @return Collection<ViewCartProductData>
     */
    public function getProducts(): Collection
    {
        $options = new ViewCartProductDataOptions([ 'cart_id' => $this->getCartId(), 'user_id' => user()->id ]);

        $records = ViewCartProductsRepository::query()->records($options);

        return ViewCartProductData::map($records);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->getCart()->products()->isEmpty();
    }

    /**
     * @return Collection<OrderData>
     */
    public function getOrders(): Collection
    {
        $options = OrderDataOptions::fromArray([ 'user_id' => user()->id ]);

        $records = OrderRepository::query()->records($options);

        return OrderData::map($records);
    }

    /**
     * @param PaymentRequest $request
     *
     * @return string
     */
    public function payment(PaymentRequest $request): string
    {
        $payment = new Payment($request);

        $payment->execute();

        $this->clear();

        return $payment->getToken();
    }
}
