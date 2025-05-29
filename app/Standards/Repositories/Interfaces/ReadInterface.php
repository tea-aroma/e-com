<?php

namespace App\Standards\Repositories\Interfaces;


use App\Standards\Data\Interfaces\OptionsInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * Interface for reading records.
 */
interface ReadInterface
{
    /**
     * Gets all records by the specified options.
     *
     * @param OptionsInterface $options
     *
     * @return Collection<Model>
     */
    public function records(OptionsInterface $options): Collection;
}
