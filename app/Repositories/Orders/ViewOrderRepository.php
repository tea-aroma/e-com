<?php

namespace App\Repositories\Orders;


use App\Data\Orders\OrderDataAttributes;
use App\Data\Orders\OrderDataOptions;
use App\Data\Orders\ViewOrderDataOptions;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ViewOrder;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class ViewOrderRepository extends Repository implements ReadInterface, FindInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = ViewOrder::class;

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
     * @return Collection<ViewOrder>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, ViewOrderDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, ViewOrderDataOptions::class));
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
     * @return ViewOrder|null
     */
    public function find(int $id): ?ViewOrder
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return $this->model->newQuery()->find($id);
        });
    }
}
