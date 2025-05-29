<?php

namespace App\Standards\Data\Abstracts;


use App\Standards\Data\Callbacks\MapCallback;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * Provides help working for data properties.
 */
abstract class Data
{
    /**
     * @var Model|null
     */
    protected ?Model $model;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->fill($values);
    }

    /**
     * Gets the all properties by the specified filters.
     *
     * @param int|null $filter
     *
     * @return \ReflectionProperty[]
     */
    protected function getProperties(?int $filter = \ReflectionProperty::IS_PUBLIC): array
    {
        return (new \ReflectionClass($this))->getProperties($filter);
    }

    /**
     * Creates a new instance by the specified array.
     *
     * @param array $values
     *
     * @return static
     */
    public static function fromArray(array $values): static
    {
        return new static($values);
    }

    /**
     * Creates a new instance by the specified model.
     *
     * @param Model $model
     *
     * @return static
     */
    public static function fromModel(Model $model): static
    {
        $instance = new static($model->toArray());

        $instance->model = $model;

        return $instance;
    }

    /**
     * Maps each model of the specified collection to current type.
     *
     * @param Collection $collection
     * @param bool       $withModel
     *
     * @return \Illuminate\Support\Collection
     */
    public static function map(Collection $collection, bool $withModel = true): \Illuminate\Support\Collection
    {
        return $collection->map(new MapCallback(static::class, $withModel));
    }

    /**
     * Converts this instance to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];

        foreach ((new \ReflectionClass($this))->getProperties() as $property)
        {
            if (!$property->isInitialized($this))
            {
                continue;
            }

            $array[ $property->getName() ] = $property->getValue($this);
        }

        return $array;
    }

    /**
     * Fills this instance by the specified values.
     *
     * @param array $values
     *
     * @return $this
     */
    public function fill(array $values): static
    {
        foreach ($this->getProperties() as $property)
        {
            if (!isset($values[ $property->getName() ]))
            {
                continue;
            }

            if ($property->getType()->getName() === 'bool' && !is_bool($values[ $property->getName() ]))
            {
                $values[ $property->getName() ] = ( $values[ $property->getName() ] === 'false' || $values[ $property->getName() ] === '0' ) ? 0 : 1;
            }

            $this->{ $property->getName() } = $values[ $property->getName() ];
        }

        return $this;
    }

    /**
     * Converts the instance to sha512.
     *
     * @return string
     */
    public function toSha512(): string
    {
        return hash('sha512', json_encode($this->toArray()));
    }

    /**
     * Gets the model.
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
