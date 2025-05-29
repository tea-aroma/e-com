<?php

namespace App\Standards\Repositories\Interfaces;


use App\Standards\Data\Interfaces\AttributesInterface;


/**
 * Interface for updating records.
 */
interface UpdateInterface
{
    /**
     * Updates a record by the specified values.
     *
     * @param AttributesInterface $values
     *
     * @return int
     */
    public function update(AttributesInterface $values): int;
}
