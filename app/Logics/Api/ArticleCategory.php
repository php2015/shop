<?php

namespace App\Logics\Api;

use App\Models\ArticleCategory as ArticleCategoryModel;
use Illuminate\Database\Eloquent\Builder;

class ArticleCategory extends ArticleCategoryModel
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    public static function getAll()
    {
        return self::select(['id', 'category_name'])
            ->orderBy('sort', 'asc')
            ->get();
    }
}
