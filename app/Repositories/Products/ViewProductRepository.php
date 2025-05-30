<?php

namespace App\Repositories\Products;


use App\Data\Products\ViewProductDataOptions;
use App\Models\ViewProduct;
use App\Standards\Data\Interfaces\OptionsInterface;
use App\Standards\Enums\CacheTag;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindInterface;
use App\Standards\Repositories\Interfaces\ReadInterface;
use Illuminate\Database\Eloquent\Collection;


/**
 * @inheritDoc
 */
class ViewProductRepository extends Repository implements ReadInterface, FindInterface
{
    /**
     * @var string|null
     */
    public ?string $modelNamespace = ViewProduct::class;

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
     * @return Collection<ViewProduct>
     */
    public function records(OptionsInterface $options): Collection
    {
        if (!is_a($options, ViewProductDataOptions::class))
        {
            throw new \LogicException(ErrorMessage::INVALID_OPTIONS->format($options::class, ViewProductDataOptions::class));
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
     * @return ViewProduct|null
     */
    public function find(int $id): ?ViewProduct
    {
        return $this->cacheRepository->remember($id, function () use ($id)
        {
            return $this->model->newQuery()->find($id);
        });
    }
}
