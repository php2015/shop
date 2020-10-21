<?php

namespace App\Logics\Admin;

use App\Models\Payment as PaymentModel;
use Illuminate\Http\Request;
use App\Helper\Date;

class Payment extends PaymentModel
{
    public static function getList()
    {
        $request = Request::capture();
        $payment_no = $request->get('payment_no');
        $sort = $request->get('sort');

        $filter = [];
        !empty($payment_no) && $filter[] = ['payment_no', 'like', "%$payment_no%"];

        $order = 'payment_time desc';
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
        return self::with(['user'])->findOrFail($id);
    }

    /**
     * 支付金额，用于仪表盘
     *
     * @param int $date
     * @return int[]
     */
    public static function sum(int $date)
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
        $current = self::where('status', self::STATUS_ON)->whereBetween('payment_time',[$currentDate['start'], $currentDate['end']])->sum('payment_price');
        $before =  self::where('status', self::STATUS_ON)->whereBetween('payment_time',[$beforeDate['start'], $beforeDate['end']])->sum('payment_price');
        $result['current'] = bcdiv($current, 100, 2);
        $result['before'] = bcdiv($before, 100, 2);
        $result['percentage'] = dod($current, $before);
        return $result;
    }

    /**
     * 支付人数，用于仪表盘
     *
     * @param int $date
     * @return int[]
     */
    public static function count(int $date)
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
        $current = self::where('status', self::STATUS_ON)->whereBetween('payment_time',[$currentDate['start'], $currentDate['end']])->count();
        $before =  self::where('status', self::STATUS_ON)->whereBetween('payment_time',[$beforeDate['start'], $beforeDate['end']])->count();
        $result['current'] = $current;
        $result['before'] = $before;
        $result['percentage'] = dod($current, $before);
        return $result;
    }
}
