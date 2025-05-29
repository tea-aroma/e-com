<?php

namespace App\Standards\Repositories\Interfaces;


use App\Standards\Data\Interfaces\AttributesInterface;
use Illuminate\Database\Eloquent\Model;


/**
 * Interface for writing records.
 */
interface WriteInterface
{
    /**
     * Writes a record by the specified values.
     *
     * @param AttributesInterface $values
     *
     * @return Model
     */
    public function write(AttributesInterface $values): Model;
}
