<?php

namespace App\Standards\Enums;


use App\Data\Settings\SettingData;
use App\Repositories\Settings\SettingRepository;


/**
 * Represent a setting key for this app.
 */
enum SettingKey: string
{
    case DEFAULT_PAYMENT_STATUS_ID = 'default_payment_status_id';

    case EXPIRED_PAYMENT_STATUS_ID = 'expired_payment_status_id';

    case EXPIRED_PAYMENT_STATUS_TIME = 'expired_payment_status_time';

    case DEFAULT_SHIPPING_STATUS_ID = 'default_shipping_status_id';

    /**
     * @return SettingData
     */
    public function data(): SettingData
    {
        return SettingData::fromModel(SettingRepository::query()->findByCode($this->value));
    }
}
