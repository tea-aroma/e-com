<?php

namespace App\Repositories\Carts;


use App\Data\Carts\CartDataAttributes;
use App\Data\Carts\CartDataOptions;
use App\Models\Cart;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\DeleteInterface;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\FindOrCreateInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\UpdateInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class CartRepository extends Repository implements ReadInterface, FindInterface, WriteInterface, UpdateInterface, FindOrCreateInterface, DeleteInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = Cart::class;

    /**
     * @inheritdoc
     *
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::CARTS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<Cart>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, CartDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, CartDataOptions::class));
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
     * @return Cart|null
     */
    public function find(int $id): ?Cart
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return $this->model->newQuery()->find($id);
        });
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $values
     *
     * @return Cart
     */
    public function write(AttributesInterface $values): Cart
    {
        if (!is_a($values, CartDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, CartDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->create($values->toArray());
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $values
     *
     * @return int
     */
    public function update(AttributesInterface $values): int
    {
        if (!is_a($values, CartDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, CartDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->where('id', '=', $values->id)->update($values->toArray());
    }

    /**
     * @inheritDoc
     *
     * @param AttributesInterface $attributes
     * @param AttributesInterface $values
     *
     * @return Model
     */
    public function findOrCreate(AttributesInterface $attributes, AttributesInterface $values): Model
    {
        if (!is_a($values, CartDataAttributes::class) || !is_a($attributes, CartDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, CartDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->firstOrCreate($attributes->toArray(), $values->toArray());
    }

    /**
     * @inheritDoc
     *
     * @param int $id
     *
     * @return mixed
     */
    public function delete(int $id): mixed
    {
        $this->cacheRepository->flush();

        return $this->model->newQuery()->where('id', '=', $id)->delete();
    }
}
