<?php

namespace App\Standards\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;


/**
 * Interface for finding a record by the specified code.
 */
interface FindByCodeInterface
{
    /**
     * Finds a record by the specified code.
     *
     * @param string $code
     * @param string $column
     *
     * @return Model|null
     */
    public function findByCode(string $code, string $column = 'code'): ?Model;
}
