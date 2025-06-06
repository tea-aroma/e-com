<?php

namespace App\Repositories\Products;


use App\Data\Products\ProductDataAttributes;
use App\Data\Products\ProductDataOptions;
use App\Models\Product;
use App\Standards\Data\Interfaces\AttributesInterface;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use App\Standards\Repositories\Interfaces\UpdateInterface;
use App\Standards\Repositories\Interfaces\WriteInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class ProductRepository extends Repository implements ReadInterface, FindInterface, WriteInterface, UpdateInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = Product::class;

    /**
     * @inheritdoc
     *
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::PRODUCTS;

    /**
     * @inheritDoc
     *
     * @param OptionsInterface $options
     *
     * @return Collection<Product>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, ProductDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, ProductDataOptions::class));
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
     * @return Product|null
     */
    public function find(int $id): ?Product
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
     * @return Product
     */
    public function write(AttributesInterface $values): Product
    {
        if (!is_a($values, ProductDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, ProductDataAttributes::class));
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
        if (!is_a($values, ProductDataAttributes::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_ATTRIBUTES->format($values::class, ProductDataAttributes::class));
        }

        $this->cacheRepository->flush();

        return $this->model->newQuery()->where('id', '=', $values->id)->update($values->toArray());
    }
}
