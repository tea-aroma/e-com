<?php

namespace App\Repositories\Orders;


use App\Data\Orders\OrderDataAttributes;
use App\Data\Orders\OrderDataOptions;
use App\Models\Order;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class OrderRepository extends Repository implements ReadInterface, FindInterface, WriteInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = Order::class;

    /**
     * @inheritdoc
     *
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::ORDERS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<Order>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, OrderDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, OrderDataOptions::class));
        }

        return $this->cacheRepository->remember($options->toSha512(), function () use ($options)
        {
            $builder = $this->model->newQuery();

            $order = explode('|', $options->order);

            $builder->orderBy($order[ 0 ], $order[ 1 ]);

            if (isset($options->payment_status_id))
            {
                $builder->where('payment_status_id', '=', $options->payment_status_id);
            }

            return $builder->get();
        });
    }

    /**
     * @inheritDoc
     *
     * @param int $id
     *
     * @return Order|null
     */
    public function find(int $id): ?Order
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return $this->model->newQuery()->find($id);
        });
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $values
     *
     * @return Order
     */
    public function write(AttributesInterface $values): Order
    {
        if (!is_a($values, OrderDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, OrderDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->create($values->toArray());
    }
}
