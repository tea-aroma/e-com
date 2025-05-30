<?php

namespace App\Standards\Enums;


/**
 * Represents a cache tag for this app.
 */
enum CacheTag: string
{
    case USERS = 'USERS';

    case CLASSIFIERS = 'CLASSIFIERS';

    case PRODUCTS = 'PRODUCTS';

    case CARTS = 'CARTS';

    case ORDERS = 'ORDERS';

    case ORDER_PRODUCTS = 'ORDER_PRODUCTS';

    case PAYMENT_HISTORY = 'PAYMENT_HISTORY';

    case PAYMENT_ADDRESSES = 'PAYMENTS_ADDRESSES';

    case SHIPPING_ADDRESSES = 'SHIPPING_ADDRESSES';
}
