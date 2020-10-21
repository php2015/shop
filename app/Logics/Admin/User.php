<?php

namespace App\Logics\Admin;

use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Helper\Date;
use Log;
use DB;

class User extends UserModel
{
    public static function getList()
    {
        $request = Request::capture();
        $id = $request->get('id');
        $nickname = $request->get('nickname');
        $city = $request->get('city');
        $gender = $request->get('gender');
        $sort = $request->get('sort');

        $filter = [];
        !empty($id) && $filter[] = ['id', 'like', "%$id%"];
        !empty($nickname) && $filter[] = ['nickname', 'like', "%$nickname%"];
        !empty($city) && $filter[] = ['city', 'like', "%$city%"];
        !empty($gender) && $filter[] = ['gender', '=', $gender];
        $order = 'id desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with(['parent', 'tag'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with(['address', 'invoice', 'tag'])
            ->findOrFail($id);
    }

    /**
     * 获取所有新用户 (未下单的用户)
     * @return mixed
     */
    public static function getNew()
    {
        $model = new static;
        return $model::whereDoesntHave('order', function (Builder $query) {
            $query->where('payment_status', Order::PAYMENT_STATUS_END);
        }, '>', 0)->get();
    }

    /**
     * 获取所有老用户
     * @return mixed
     */
    public static function getOld()
    {
        $model = new static;
        return $model::whereHas('order', function (Builder $query) {
            $query->where('payment_status', Order::PAYMENT_STATUS_END);
        }, '>', 0)->get();
    }

    /**
     * 用户订单，用于用户详细
     *
     * @param int $id
     * @return mixed
     */
    public static function getOrderList(int $id)
    {
        $request = Request::capture();
        $order_no = $request->get('order_no');
        $sort = $request->get('sort');

        $filter = [];
        !empty($order_no) && $filter[] = ['order_no', 'like', "%$order_no%"];
        $order = 'created_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return Order::with('goods')
            ->where('user_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 用户优惠卷，用于用户详细
     *
     * @param int $id
     * @return mixed
     */
    public static function getCouponList(int $id)
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
        $order = 'created_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return CouponReceive::where('user_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 用户积分，用于用户详细
     *
     * @param int $id
     * @return mixed
     */
    public static function getPointsList(int $id)
    {
        $request = Request::capture();
        $intro = $request->get('intro');
        $sort = $request->get('sort');

        $filter = [];
        !empty($intro) && $filter[] = ['intro', 'like', "%$intro%"];
        $order = 'created_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return Points::where('user_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 用户佣金，用于用户详细
     *
     * @param int $id
     * @return mixed
     */
    public static function getBonusList(int $id)
    {
        $request = Request::capture();
        $sort = $request->get('sort');

        $filter = [];
        $order = 'created_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return DistributionBonus::with(['order', 'from'])
            ->where('user_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 用户购物车，用于用户详细
     *
     * @param int $id
     * @return mixed
     */
    public static function getCartList(int $id)
    {
        $request = Request::capture();
        $sort = $request->get('sort');

        $filter = [];
        $order = 'created_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return Cart::has('goods')
            ->with(['goods', 'sku'])
            ->where('user_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 用户收藏，用于用户详细
     *
     * @param int $id
     * @return mixed
     */
    public static function getLikeList(int $id)
    {
        $request = Request::capture();
        $sort = $request->get('sort');

        $filter = [];
        $order = 'created_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return GoodsLike::has('goods')
            ->with('goods')
            ->where('user_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }


    public static function editTag(array $data)
    {
        try {
            DB::beginTransaction();
            $detail = self::detail($data['id']);
            $detail->tag()->detach();
            $detail->tag()->attach($data['tag']);
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function editPoints(array $data)
    {
        return Points::record($data['points'], $data['intro'], $data['id']);
    }

    /**
     * 新用户，用于仪表盘
     *
     * @param int $date
     * @return int[]
     */
    public static function statisticNew(int $date)
    {
        $result = [
            'current' => 0,
            'before' => 0
        ];
        switch($date) {
            case 0:
                $currentDate = Date::today();
                $beforeDate = Date::yesterday();
                break;
            case 1:
                $currentDate = Date::yesterday();
                $beforeDate = Date::beforeDay(2);
                break;
            case 2:
                $currentDate = Date::week();
                $beforeDate = Date::beforeWeek(1);
                break;
            case 3:
                $currentDate = Date::beforeWeek(1);
                $beforeDate = Date::beforeWeek(2);
                break;
            case 4:
                $currentDate = Date::month();
                $beforeDate = Date::beforeMonth(1);
                break;
            case 5:
                $currentDate = Date::beforeMonth(1);
                $beforeDate = Date::beforeMonth(2);
                break;
        }
        $current = self::whereBetween('register_time',[$currentDate['start'], $currentDate['end']])->count();
        $before =  self::whereBetween('register_time',[$beforeDate['start'], $beforeDate['end']])->count();
        $result['current'] = $current;
        $result['before'] = $before;
        $result['percentage'] = dod($current, $before);
        return $result;
    }

    /**
     * 老用户，用于仪表盘
     *
     * @param int $date
     * @return int[]
     */
    public static function statisticOld(int $date)
    {
        $result = [
            'current' => 0,
            'before' => 0
        ];
        switch($date) {
            case 0:
                $currentDate = Date::today();
                $beforeDate = Date::yesterday();
                break;
            case 1:
                $currentDate = Date::yesterday();
                $beforeDate = Date::beforeDay(2);
                break;
            case 2:
                $currentDate = Date::week();
                $beforeDate = Date::beforeWeek(1);
                break;
            case 3:
                $currentDate = Date::beforeWeek(1);
                $beforeDate = Date::beforeWeek(2);
                break;
            case 4:
                $currentDate = Date::month();
                $beforeDate = Date::beforeMonth(1);
                break;
            case 5:
                $currentDate = Date::beforeMonth(1);
                $beforeDate = Date::beforeMonth(2);
                break;
        }
        $current = self::whereBetween('last_login_time',[$currentDate['start'], $currentDate['end']])->count();
        $before =  self::whereBetween('last_login_time',[$beforeDate['start'], $beforeDate['end']])->count();
        $result['current'] = $current;
        $result['before'] = $before;
        $result['percentage'] = dod($current, $before);
        return $result;
    }
}
