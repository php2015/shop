<?php

namespace App\Logics\Api;

use App\Models\GoodsHistory as GoodsHistoryModel;
use Illuminate\Http\Request;
use App\Helper\Date;

class GoodsHistory extends GoodsHistoryModel
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
        // 已登录的用户才记录历史
        if ($user_id = User::getId()) {
            $today = Date::today();
            $model = self::whereBetween('view_time',[$today['start'], $today['end']])
                ->where(['goods_id' => $id, 'user_id' => $user_id])
                ->first();
            // 当日未浏览过该商品才加入历史
            if (empty($model)) {
                $model = new static;
                $model->goods_id = $id;
                $model->user_id = $user_id;
                $model->view_total = 1;
                $model->view_time = time();
                $model->save();
            } else {
                $model->view_total += 1;
                $model->save();
            }
        }
        return true;
    }

    public static function remove(int $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
