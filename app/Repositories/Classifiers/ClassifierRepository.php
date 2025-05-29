<?php

namespace App\Repositories\Classifiers;


use App\Data\Classifiers\ClassifierDataOptions;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ForModelInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class ClassifierRepository extends Repository implements ForModelInterface, ReadInterface, FindInterface
{
    /**
     * @inheritdoc
     *
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::CLASSIFIERS;

    /**
     * @inheritDoc
     *
     * @param string $model
     *
     * @return static
     */
    public static function forModel(string $model): static
    {
        return new self($model);
    }

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<Model>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, ClassifierDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, ClassifierDataOptions::class));
        }

        return $this->cacheRepository->remember($options->toSha512(), function () use ($options)
        {
            return $this->model->newQuery()->get();
        });
    }

    /**
     * @inheritDoc
     *
     * @param int $id
     *
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return $this->model->newQuery()->find($id);
        });
    }
}
