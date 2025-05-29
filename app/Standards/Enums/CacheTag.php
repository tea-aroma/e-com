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

    case PAYMENT_ADDRESSES = 'PAYMENTS';

    case SHIPPING_ADDRESSES = 'SHIPPING';
}
