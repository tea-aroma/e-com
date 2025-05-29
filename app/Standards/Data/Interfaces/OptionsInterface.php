<?php

namespace App\Standards\Data\Interfaces;


/**
 * Interface for the Data classes which contains option data properties.
 */
interface OptionsInterface
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function toSha512(): string;
}
