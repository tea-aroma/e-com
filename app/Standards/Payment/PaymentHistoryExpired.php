<?php

namespace App\Standards\Payment;


use App\Data\Payments\PaymentHistoryDataAttributes;
use App\Models\ViewLatestPaymentHistory;
use App\Repositories\Classifiers\ClassifierRepository;
use App\Repositories\Payments\PaymentHistoryRepository;
use App\Repositories\Payments\ViewLatestPaymentHistoryRepository;
use App\Standards\Enums\ClassifierModel;
use App\Standards\Enums\SettingKey;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


/**
 *
 */
readonly class PaymentHistoryExpired
{
    /**
     * @return void
     */
    public function execute(): void
    {
        DB::beginTransaction();

        $expiredPaymentStatus = ClassifierRepository::forModel(ClassifierModel::PAYMENT_STATUS->value)->find(SettingKey::EXPIRED_PAYMENT_STATUS_ID->data()->value);

        foreach ($this->getRecords() as $record)
        {
            $attributes = new PaymentHistoryDataAttributes($record->toArray());

            unset($attributes->token);

            $attributes->old_payment_status_id = $record->new_payment_status_id;

            $attributes->old_payment_status_name = $record->new_payment_status_name;

            $attributes->new_payment_status_id = $expiredPaymentStatus->id;

            $attributes->new_payment_status_name = $expiredPaymentStatus->name;

            $this->updateOldRecord($record);

            PaymentHistoryRepository::query()->write($attributes);
        }

        DB::commit();
    }

    /**
     * @return Collection<ViewLatestPaymentHistory>
     */
    public function getRecords(): Collection
    {
        return ViewLatestPaymentHistoryRepository::query()->getExpiredRecords();
    }

    /**
     * @param ViewLatestPaymentHistory $record
     *
     * @return void
     */
    public function updateOldRecord(ViewLatestPaymentHistory $record): void
    {
        $values = new PaymentHistoryDataAttributes([ 'id' => $record->id, 'token' => '' ]);

        PaymentHistoryRepository::query()->update($values);
    }
}
