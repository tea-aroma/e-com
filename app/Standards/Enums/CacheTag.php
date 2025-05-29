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
}
