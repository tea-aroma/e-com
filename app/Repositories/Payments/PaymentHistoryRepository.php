<?php

namespace App\Repositories\Payments;


use App\Data\Payments\PaymentHistoryDataAttributes;
use App\Data\Payments\PaymentHistoryDataOptions;
use App\Models\PaymentHistory;
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
class PaymentHistoryRepository extends Repository implements ReadInterface, FindInterface, WriteInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = PaymentHistory::class;

    /**
     * @inheritdoc
     *
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::PAYMENT_HISTORY;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<PaymentHistory>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, PaymentHistoryDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, PaymentHistoryDataOptions::class));
        }

        return $this->cacheRepository->remember($options->toSha512(), function () use ($options)
        {
            return $this->model->newQuery()->get();
        });
    }

    /**
     * @inheritDoc
     *
     * @param int $id
     *
     * @return PaymentHistory|null
     */
    public function find(int $id): ?PaymentHistory
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
     * @return PaymentHistory
     */
    public function write(AttributesInterface $values): PaymentHistory
    {
        if (!is_a($values, PaymentHistoryDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, PaymentHistoryDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->create($values->toArray());
    }
}
