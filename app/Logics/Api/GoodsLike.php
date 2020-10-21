<?php

namespace App\Logics\Api;

use App\Models\GoodsLike as GoodsLikeModel;
use Illuminate\Http\Request;

class GoodsLike extends GoodsLikeModel
{
    public static function getList()
    {
        $request = Request::capture();
        $filter = ['user_id' => User::getId()];
        $order = 'created_at desc';

        return self::has('goods')
            ->with(['goods' => function($query) {
            $query->select(['id', 'goods_name', 'subtitle', 'sales_price', 'image']);
        }])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function saveData(int $id)
    {
        $user = User::model();
        if ($model = $user->like()
            ->where(['goods_id' => $id])
            ->first()) {
            $model->delete();
        } else {
            $user->like()->save(
                new static([
                    'goods_id' => $id,
                    'add_time' => time()
                ])
            );
        }
        return true;
    }

    public static function isLike(int $id)
    {
        if ($user_id = User::getId()) {
            return User::model()->like()
                    ->where(['goods_id' => $id])
                    ->first() !== null;
        }
        return false;
    }

    public static function remove(int $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
