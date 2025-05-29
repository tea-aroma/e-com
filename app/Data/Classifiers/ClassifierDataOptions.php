<?php

namespace App\Data\Classifiers;


use App\Standards\Data\Interfaces\OptionsInterface;


/**
 * @inheritDoc
 */
class ClassifierDataOptions extends ClassifierData implements OptionsInterface
{
    /**
     * @var string
     */
    public string $classifier_model;
}
