<?php

namespace App\Standards\Data\Traits;


use App\Repositories\Classifiers\ClassifierRepository;
use App\Standards\Enums\ClassifierModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Provides the logic for classifier relations.
 */
trait HasClassifier
{
    /**
     * Gets the classifier data by the specified type.
     *
     * @param ClassifierModel $classifier
     *
     * @return Model
     */
    public function classifier(ClassifierModel $classifier): Model
    {
        return ClassifierRepository::forModel($classifier->value)->find($this->{ $classifier->getKey() });
    }
}
