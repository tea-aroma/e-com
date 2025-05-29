<?php

namespace App\Standards\Repositories\Interfaces;


use App\Standards\Data\Interfaces\AttributesInterface;
use Illuminate\Database\Eloquent\Model;


/**
 * Interface for writing or updating records.
 */
interface WriteOrUpdateInterface
{
    /**
     * Writes or updates a record by the specified attributes and values.
     *
     * @param AttributesInterface $attributes
     * @param AttributesInterface $values
     *
     * @return Model
     */
    public function writeOrUpdate(AttributesInterface $attributes, AttributesInterface $values): Model;
}
