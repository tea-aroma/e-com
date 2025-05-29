<?php

namespace App\Repositories\CartProducts;


use App\Data\CartProducts\ViewCartProductDataOptions;
use App\Models\ViewCartProduct;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class ViewCartProductsRepository extends Repository implements ReadInterface, FindInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = ViewCartProduct::class;

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
     * @return Collection<ViewCartProduct>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, ViewCartProductDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, ViewCartProductDataOptions::class));
        }

        return $this->cacheRepository->remember($options->toSha512(), function () use ($options)
        {
            $builder = $this->model->newQuery();

            if (isset($options->cart_id))
            {
                $builder = $builder->where('cart_id', $options->cart_id);
            }

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
     * @return ViewCartProduct|null
     */
    public function find(int $id): ?ViewCartProduct
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return $this->model->newQuery()->find($id);
        });
    }
}
