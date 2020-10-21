<?php

namespace App\Logics\Api;

use App\Models\ArticleBanner as ArticleBannerModel;
use Illuminate\Database\Eloquent\Builder;

class ArticleBanner extends ArticleBannerModel
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
        return self::orderBy('sort', 'asc')
            ->get();
    }
}
