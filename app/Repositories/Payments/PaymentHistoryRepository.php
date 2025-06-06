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
use App\Standards\Repositories\Interfaces\FindByCodeInterface;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\UpdateInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class PaymentHistoryRepository extends Repository implements ReadInterface, FindInterface, WriteInterface, UpdateInterface, FindByCodeInterface
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

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $values
     *
     * @return int
     */
    public function update(AttributesInterface $values): int
    {
        if (!is_a($values, PaymentHistoryDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, PaymentHistoryDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->where('id', '=', $values->id)->update($values->toArray());
    }

    /**
     * @inheritDoc
     *
     * @param string $code
     * @param string $column
     *
     * @return Model|null
     */
    public function findByCode(string $code, string $column = 'token'): ?Model
    {
        return $this->cacheRepository->remember($code . $column, function () use ($column, $code)
        {
            return $this->model->newQuery()->where($column, '=', $code)->first();
        });
    }
}
