<?php

namespace App\Repositories\Orders;


use App\Data\OrderProducts\OrderProductDataAttributes;
use App\Data\OrderProducts\OrderProductDataOptions;
use App\Models\OrderProduct;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class OrderProductRepository extends Repository implements ReadInterface, WriteInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = OrderProduct::class;

    /**
     * @inheritdoc
     *
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::ORDER_PRODUCTS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<OrderProduct>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, OrderProductDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, OrderProductDataOptions::class));
        }

        return $this->cacheRepository->remember($options->toSha512(), function () use ($options)
        {
            $builder = $this->model->newQuery();

            $order = explode('|', $options->order);

            $builder->orderBy($order[ 0 ], $order[ 1 ]);

            return $builder->get();
        });
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $values
     *
     * @return OrderProduct
     */
    public function write(AttributesInterface $values): OrderProduct
    {
        if (!is_a($values, OrderProductDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, OrderProductDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->create($values->toArray());
    }
}
