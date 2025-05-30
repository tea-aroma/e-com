<?php

namespace App\Standards\Payment;


use App\Data\Payments\PaymentHistoryDataAttributes;
use App\Repositories\Classifiers\ClassifierRepository;
use App\Repositories\Payments\PaymentHistoryRepository;
use App\Standards\Enums\ClassifierModel;
use App\Standards\Enums\SettingKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/**
 *
 */
readonly class PaymentHistory
{
    /**
     * @var string
     */
    public string $token;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return bool
     */
    public function accept(): bool
    {
        $this->getRecord();

        $attributes = PaymentHistoryDataAttributes::fromModel($this->getRecord());

        unset($attributes->token);

        $attributes->old_payment_status_id = $attributes->new_payment_status_id;

        $attributes->old_payment_status_name = $attributes->new_payment_status_name;

        $newPaymentStatus = ClassifierRepository::forModel(ClassifierModel::PAYMENT_STATUS->value)->find(SettingKey::COMPLETED_PAYMENT_STATUS_ID->data()->value);

        $attributes->new_payment_status_id = $newPaymentStatus->id;

        $attributes->new_payment_status_name = $newPaymentStatus->name;

        DB::beginTransaction();

        PaymentHistoryRepository::query()->write($attributes);

        $this->updateOldRecord();

        DB::commit();

        return true;
    }

    /**
     * @return Model
     */
    public function getRecord(): Model
    {
        return PaymentHistoryRepository::query()->findByCode($this->token);
    }

    /**
     * @return void
     */
    public function updateOldRecord(): void
    {
        $values = new PaymentHistoryDataAttributes([ 'id' => $this->getRecord()->id, 'token' => date('Y-m-d H:i:s') ]);

        PaymentHistoryRepository::query()->update($values);
    }
}
