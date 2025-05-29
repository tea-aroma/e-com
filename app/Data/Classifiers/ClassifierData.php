<?php

namespace App\Data\Classifiers;


use App\Standards\Data\Abstracts\Data;


/**
 * @inheritDoc
 */
class ClassifierData extends Data
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $code;

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
