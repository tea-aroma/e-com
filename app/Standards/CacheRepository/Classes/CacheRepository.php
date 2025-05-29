<?php

namespace App\Standards\CacheRepository\Classes;


use App\Standards\Enums\CacheTag;
use App\Standards\Enums\CacheTTL;
use App\Standards\Repositories\Abstracts\Repository;
use Illuminate\Support\Facades\Cache;


/**
 * Provides a logical wrapper for caching repository data.
 */
readonly class CacheRepository
{
    /**
     * The cache tag.
     *
     * @var CacheTag
     */
    public CacheTag $cacheTag;

    /**
     * The repository instance.
     *
     * @var Repository
     */
    public Repository $repository;

    /**
     * The cache ttl.
     *
     * @var CacheTTL
     */
    public CacheTTL $ttl;

    /**
     * @param CacheTag   $cacheTag
     * @param Repository $repository
     * @param CacheTTL        $ttl
     */
    public function __construct(CacheTag $cacheTag, Repository $repository, CacheTTL $ttl)
    {
        $this->cacheTag = $cacheTag;

        $this->repository = $repository;

        $this->ttl = $ttl;
    }

    /**
     * Gets the cache value by the specified key.
     *
     * @param string $key
     *
     * @return mixed
     */
    protected function get(string $key): mixed
    {
        return Cache::tags($this->cacheTag->value)->get($this->repository->getModelNamespace() . $key);
    }

    /**
     * Get an item from the cache by tag, or execute the given Closure and store the result.
     *
     * @param string   $key
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function remember(string $key, \Closure $callback): mixed
    {
        $value = $this->get($key) ?? $callback();

        if (is_null($value))
        {
            return null;
        }

        Cache::tags($this->cacheTag->value)->put($this->repository->getModelNamespace() . $key, $value, $this->ttl->value);

        return $value;
    }

    /**
     * Remove all items from the cache by the tag.
     *
     * @return void
     */
    public function flush(): void
    {
        Cache::tags($this->cacheTag->value)->flush();
    }
}
