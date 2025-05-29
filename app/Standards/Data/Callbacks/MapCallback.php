<?php

namespace App\Standards\Data\Callbacks;


use App\Standards\Data\Abstracts\Data;
use Illuminate\Database\Eloquent\Model;


/**
 * Converts the specified Model to the specified Data.
 */
class MapCallback
{
    /**
     * @var class-string<Data>
     */
    public string $namespace;

    /**
     * @var bool
     */
    public bool $withModel;

    /**
     * @param string $namespace
     * @param bool   $withModel
     */
    public function __construct(string $namespace, bool $withModel)
    {
        $this->namespace = $namespace;

        $this->withModel = $withModel;
    }

    /**
     * @param Model $model
     *
     * @return Data
     */
    public function __invoke(Model $model): Data
    {
        if (!$this->withModel)
        {
            return $this->namespace::fromArray($model->toArray());
        }

        return $this->namespace::fromModel($model);
    }
}
