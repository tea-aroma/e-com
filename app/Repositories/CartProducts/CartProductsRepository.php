<?php

namespace App\Repositories\CartProducts;


use App\Data\CartProducts\CartProductDataAttributes;
use App\Data\CartProducts\CartProductDataOptions;
use App\Models\CartProduct;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\DeleteInterface;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use App\Standards\Repositories\Interfaces\WriteOrUpdateInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class CartProductsRepository extends Repository implements ReadInterface, FindInterface, WriteInterface, WriteOrUpdateInterface, DeleteInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = CartProduct::class;

    /**
     * @inheritdoc
     *
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::CARTS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<CartProduct>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, CartProductDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, CartProductDataOptions::class));
        }

        $this->cacheRepository->flush();

        return $this->cacheRepository->remember($options->toSha512(), function () use ($options)
        {
            $builder = $this->model->newQuery();

            if (isset($options->cart_id))
            {
                $builder = $builder->where('cart_id', $options->cart_id);
            }

            $builder = $builder->with('product');

            $order = explode('|', $options->order);

            $builder->orderBy($order[ 0 ], $order[ 1 ]);

            return $builder->get();
        });
    }

    /**
     * @inheritDoc
     *
     * @param int $id
     *
     * @return CartProduct|null
     */
    public function find(int $id): ?CartProduct
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return $this->model->newQuery()->where('product_id', $id)->first();
        });
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $values
     *
     * @return CartProduct
     */
    public function write(AttributesInterface $values): CartProduct
    {
        if (!is_a($values, CartProductDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, CartProductDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->create($values->toArray());
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $attributes
     * @param AttributesInterface $values
     *
     * @return Model
     */
    public function writeOrUpdate(AttributesInterface $attributes, AttributesInterface $values): Model
    {
        if (!is_a($values, CartProductDataAttributes::class) || !is_a($attributes, CartProductDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, CartProductDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->updateOrCreate($attributes->toArray(), $values->toArray());
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function delete(int $id): mixed
    {
        $this->cacheRepository->flush();

        return $this->model->newQuery()->where('product_id', '=', $id)->delete();
    }
}
