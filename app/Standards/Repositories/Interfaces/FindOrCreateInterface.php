<?php

namespace App\Standards\Repositories\Interfaces;


use App\Standards\Data\Interfaces\AttributesInterface;
use Illuminate\Database\Eloquent\Model;


/**
 * Interface for finding or updating records.
 */
interface FindOrCreateInterface
{
    /**
     * Finds or creates a record by the specified attributes and values.
     *
     * @param AttributesInterface $attributes
     * @param AttributesInterface $values
     *
     * @return Model
     */
    public function findOrCreate(AttributesInterface $attributes, AttributesInterface $values): Model;
}
