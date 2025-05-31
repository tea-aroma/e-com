<?php

namespace App\Standards\Enums;


use App\Data\Settings\SettingData;
use App\Models\Setting;
use App\Repositories\Settings\SettingRepository;


/**
 * Represent a setting key for this app.
 */
enum SettingKey: string
{
    case DEFAULT_PAYMENT_STATUS_ID = 'default_payment_status_id';

    case COMPLETED_PAYMENT_STATUS_ID = 'completed_payment_status_id';

    case EXPIRED_PAYMENT_STATUS_ID = 'expired_payment_status_id';

    case EXPIRED_PAYMENT_STATUS_SECONDS = 'expired_payment_status_seconds';

    case DEFAULT_SHIPPING_STATUS_ID = 'default_shipping_status_id';

    case CRON_INTERVAL = 'cron_interval';

    /**
     * @return SettingData
     */
    public function data(): SettingData
    {
        return SettingData::fromModel(SettingRepository::query()->findByCode($this->value));
    }

    /**
     * @return Setting|null
     */
    public function model(): ?Setting
    {
        return SettingRepository::query()->findByCode($this->value);
    }
}
