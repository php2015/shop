<?php

namespace App\Logics\Api;

use App\Models\Article as ArticleModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Article extends ArticleModel
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        $category = $request->get('category');

        $filter = [];
        if (empty($category)) {
            $filter[] = ['is_best', '=', self::IS_BEST_NO];
        } else {
            $filter[] = ['category_id', '=', $category];
        }

        $order = 'release_time desc';

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail($id)
    {
        $detail = self::findOrFail($id);

        $detail->views += 1;
        $detail->save();
        return $detail;
    }
}
