<?php

namespace App\Repositories\Settings;


use App\Models\Setting;
use App\Standards\Enums\CacheTag;
use App\Standards\Repositories\Abstracts\Repository;
use App\Standards\Repositories\Interfaces\FindByCodeInterface;
use Illuminate\Database\Eloquent\Model;


/**
 * @inheritDoc
 */
class SettingRepository extends Repository implements FindByCodeInterface
{
    protected ?string $modelNamespace = Setting::class;

    /**
     * @inheritdoc
     *
     * @var CacheTag
     */
    protected CacheTag $cacheTag = CacheTag::CLASSIFIERS;

    /**
     * @inheritDoc
     *
     * @param string $code
     * @param string $column
     *
     * @return Setting|null
     */
    public function findByCode(string $code, string $column = 'key'): ?Setting
    {
        return $this->cacheRepository->remember($code . $column, function () use ($code, $column)
        {
            return $this->model->newQuery()->where($column, '=', $code)->first();
        });
    }
}
