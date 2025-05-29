<?php

namespace App\Standards\Enums;


/**
 * Represents a time to live value for cache.
 */
enum CacheTTL: int
{
    case DEFAULT = 3600;
}
