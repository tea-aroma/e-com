<?php

namespace App\Repositories\Users;


use App\Data\Classifiers\ClassifierData;
use App\Data\Users\UserData;
use App\Data\Users\UserDataOptions;
use App\Models\User;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindByCodeInterface;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class UserRepository extends Repository implements ReadInterface, FindInterface, FindByCodeInterface, WriteInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = User::class;

    /**
     * @inheritdoc
     *
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::USERS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<ClassifierData>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, UserDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, UserDataOptions::class));
        }

        return $this->cacheRepository->remember($options->toSha512(), function () use ($options)
        {
            return UserData::map($this->model->newQuery()->get());
        });
    }

    /**
     * @inheritDoc
     *
     * @param int $id
     *
     * @return User|null
     */
    public function find(int $id): ?User
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return ClassifierData::fromModel($this->model->newQuery()->find($id));
        });
    }

    /**
     * @inheritDoc
     *
     * @param string $code
     * @param string $column
     *
     * @return User|null
     */
    public function findByCode(string $code, string $column = 'email'): ?User
    {
        return $this->cacheRepository->remember($code . $column, function () use ($code, $column)
        {
            return $this->model->newQuery()->where($column, $code)->first();
        });
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $values
     *
     * @return User
     */
    public function write(AttributesInterface $values): User
    {
        $this->cacheRepository->flush();

        return $this->model->newQuery()->create($values->toArray());
    }
}
