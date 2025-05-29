<?php

namespace App\Standards\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;


/**
 * Interface for Repository classes that can be created with a specified Model.
 */
interface ForModelInterface
{
    /**
     * Creates a new instance with the specified Model.
     *
     * @param class-string<Model> $model
     *
     * @return static
     */
    public static function forModel(string $model): static;
}
