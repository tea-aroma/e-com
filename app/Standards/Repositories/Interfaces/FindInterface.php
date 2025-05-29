<?php

namespace App\Standards\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;


/**
 * Interface for finding a record.
 */
interface FindInterface
{
    /**
     * Finds a record by the specified id.
     *
     * @param int $id
     *
     * @return Model|null
     */
    public function find(int $id): ?Model;
}
