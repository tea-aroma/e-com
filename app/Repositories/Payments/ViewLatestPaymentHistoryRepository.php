<?php

namespace App\Repositories\Payments;


use App\Data\Payments\PaymentHistoryDataOptions;
use App\Models\ViewLatestPaymentHistory;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Enums\SettingKey;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\ReadInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class ViewLatestPaymentHistoryRepository extends Repository implements ReadInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = ViewLatestPaymentHistory::class;

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
     * @return Collection<ViewLatestPaymentHistory>
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
     * @return Collection
     */
    public function getExpiredRecords(): Collection
    {
        $defaultPaymentStatus = SettingKey::DEFAULT_PAYMENT_STATUS_ID->data()->value;

        $expiredPaymentStatusSeconds = (int) SettingKey::EXPIRED_PAYMENT_STATUS_SECONDS->data()->value;

        return $this->model->newQuery()
            ->where('new_payment_status_id', '=', $defaultPaymentStatus)
            ->whereRaw("created_at + interval '{$expiredPaymentStatusSeconds} seconds' < current_timestamp")
            ->get();
    }
}
