<?php

namespace App\Logics\Admin;

use App\Models\CouponReceive as CouponReceiveModel;
use Illuminate\Http\Request;

class CouponReceive extends CouponReceiveModel
{
    public static function getList()
    {
        $request = Request::capture();
        $coupon_name = $request->get('name');
        $coupon_type = $request->get('type');
        $status = $request->get('status');
        $sort = $request->get('sort');

        $filter = [];
        !empty($coupon_name) && $filter[] = ['coupon_name', 'like', "%$coupon_name%"];
        !empty($coupon_type) && $filter[] = ['coupon_type', '=', $coupon_type];
        !empty($status) && $filter[] = ['status', '=', $status];
        $order = 'receive_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with(['user'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function changeStatus(array $data)
    {
        $model = self::detail($data['id']);
        $model->{$data['field']} = $model->{$data['field']} == 10 ? 20 : 10;
        $model->save();
        return true;
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
