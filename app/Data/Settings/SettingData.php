<?php

namespace App\Data\Settings;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class SettingData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $key;

    /**
     * @var string
     */
    public string $value;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var int
     */
    public int $sort_order;

    /**
     * @var bool
     */
    public bool $is_active;

    /**
     * @var string
     */
    public string $created_at;

    /**
     * @var string
     */
    public string $updated_at;

}
