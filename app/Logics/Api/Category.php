<?php

namespace App\Logics\Api;

use App\Models\Category as CategoryModel;
use Illuminate\Database\Eloquent\Builder;
use App\Helper\Tree;

class Category extends CategoryModel
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    public static function getList(int $level)
    {
        return self::where('level', '<', $level)
            ->orderBy('sort', 'asc')
            ->get();
    }

    public static function getTree()
    {
        $data = self::orderBy('sort', 'asc')->get();
        return Tree::make($data);
    }
}
