<?php

namespace App\Standards\Enums;


use App\Models\Brand;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Setting;
use App\Models\ShippingMethod;
use App\Models\ShippingStatus;


/**
 * Represents a classifier name for this app.
 */
enum ClassifierModel: string
{
    case CATEGORY = Category::class;

    case BRAND = Brand::class;

    case PAYMENT_METHOD = PaymentMethod::class;

    case PAYMENT_STATUS = PaymentStatus::class;

    case SHIPPING_METHOD = ShippingMethod::class;

    case SHIPPING_STATUS = ShippingStatus::class;

    case SETTINGS = Setting::class;

    /**
     * Gets the key for access database columns.
     *
     * @param string $key
     *
     * @return string
     */
    public function getKey(string $key = 'id'): string
    {
        return strtolower($this->name) . '_' . $key;
    }

    /**
     * Gets a case by the specified name.
     *
     * @param string $name
     *
     * @return ClassifierModel|null
     */
    public static function fromName(string $name): ?ClassifierModel
    {
        foreach (self::cases() as $case)
        {
            if ($case->name === $name)
            {
                return $case;
            }
        }

        return null;
    }
}
