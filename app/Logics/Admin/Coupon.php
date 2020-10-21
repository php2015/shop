<?php

namespace App\Logics\Admin;

use App\Models\Coupon as CouponModel;
use Illuminate\Http\Request;
use App\Exceptions\AppException;
use App\Events\Coupon\IssueEvent;
use Event;
use Log;
use DB;

class Coupon extends CouponModel
{
    const FIND_DATA = '该优惠卷已被用户领取，不允许删除';

    public static function getList()
    {
        $request = Request::capture();
        $coupon_name = $request->get('name');
        $coupon_type = $request->get('type');
        $coupon_visible = $request->get('visible');
        $sort = $request->get('sort');

        $filter = [];
        !empty($coupon_name) && $filter[] = ['coupon_name', 'like', "%$coupon_name%"];
        !empty($coupon_type) && $filter[] = ['coupon_type', '=', $coupon_type];
        !empty($coupon_visible) && $filter[] = ['coupon_visible', '=', $coupon_visible];
        $order = 'created_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * Dialog 选择优惠卷
     * @return mixed
     */
    public static function getSelectList()
    {
        $request = Request::capture();
        $coupon_name = $request->get('name');
        $coupon_type = $request->get('type');
        $sort = $request->get('sort');

        $filter[] = ['status', '=', self::STATUS_ON];
        !empty($coupon_name) && $filter[] = ['coupon_name', 'like', "%$coupon_name%"];
        !empty($coupon_type) && $filter[] = ['coupon_type', '=', $coupon_type];
        $order = 'created_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    /**
     * @param array $data
     * @return bool
     */
    public static function add(array $data)
    {
        return (new static($data))
            ->save();
    }

    public static function edit(array $data)
    {
        return self::detail($data['id'])
            ->fill($data)
            ->save();
    }

    public static function issue(array $data)
    {
        try {
            $user = [];
            if ($data['group'] == self::COUPON_ISSUE_SELECT) {
                $id = array_column($data['user'], 'id');
                $user = User::whereIn('id', $id)->get();
            }
            if ($data['group'] == self::COUPON_ISSUE_NEW) {
                $user = User::getNew();
            }
            if ($data['group'] == self::COUPON_ISSUE_OLD) {
                $user = User::getOld();
            }
            DB::beginTransaction();
            $model = (new static)->create($data);
            foreach ($user as $item) {
                if (self::give($model, $item)) {
                    Event::dispatch(new IssueEvent());
                }
            }
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function changeStatus(int $id)
    {
        $model = self::detail($id);
        $model->status = self::STATUS_OFF;
        $model->save();
        return true;
    }

    public static function remove(string $id)
    {
        $model = self::detail($id);
        if ($model->receive()->count() > 0) {
            throw new AppException(self::FIND_DATA);
        }

        return self::destroy($id) > 0;
    }
}
