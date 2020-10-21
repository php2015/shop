<?php

namespace App\Logics\Admin;

use App\Models\Order as OrderModel;
use App\Logics\Api\Order as OrderApi;
use Illuminate\Database\Eloquent\Builder;
use App\Events\Order\ShipmentEvent;
use App\Jobs\OrderReceive;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\Prints\Factory;
use App\Exceptions\AppException;
use App\Helper\Date;
use Event;
use Log;
use DB;

class Order extends OrderModel
{
    public static function getList()
    {
        $request = Request::capture();
        $sort = $request->get('sort');

        $model = new static;
        $model->getQuery();
        $order = 'id desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with(['goods', 'user'])
            ->where($model->filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with(['goods', 'invoice', 'logistics.express', 'fetch.address', 'user'])
            ->findOrFail($id);
    }

    /**
     * 发货
     * @param array $data
     * @return bool
     */
    public static function shipment(array $data)
    {
        try {
            DB::beginTransaction();
            $order = self::detail($data['order_id']);
            $order->shipment_time = time();
            $order->shipment_status = self::LOGISTICS_STATUS_END;
            $order->order_status = self::UN_RECEIVE;
            $order->save();

            $order->logistics->express_id = $data['express_id'];
            $order->logistics->express_no = $data['express_no'];
            $order->logistics->contact = $data['contact'];
            $order->logistics->phone = $data['phone'];
            $order->logistics->province = $data['province'];
            $order->logistics->city = $data['city'];
            $order->logistics->district = $data['district'];
            $order->logistics->detail = $data['detail'];
            $order->logistics->save();
            Event::dispatch(new ShipmentEvent($order));
            OrderReceive::dispatch($order);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            return false;
        }
    }

    /**
     * 补打订单
     *
     * @param int $id
     * @return bool
     * @throws AppException
     */
    public static function prints(int $id)
    {
        $setting = Setting::getInstance('prints.base')->fetch();

        if ($setting['status'] == Setting::PRINTS) {
            $order = OrderApi::detail($id);
            if (Factory::getInstance($setting)->prints($order)) {
                return true;
            }
        }
        throw new AppException('系统不支持打印，请在设置中查看');
    }

    /**
     * 用于仪表盘
     *
     * @param int $date
     * @return int[]
     */
    public static function statistic(int $date)
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
        $current = self::where('payment_status', self::PAYMENT_STATUS_END)
            ->whereBetween('order_time',[$currentDate['start'], $currentDate['end']])
            ->count();
        $before =  self::where('payment_status', self::PAYMENT_STATUS_END)
            ->whereBetween('order_time',[$beforeDate['start'], $beforeDate['end']])
            ->count();
        $result['current'] = $current;
        $result['before'] = $before;
        $result['percentage'] = dod($current, $before);
        return $result;
    }

    /**
     * 用于仪表盘，代发货订单 5 条
     * @return mixed
     */
    public static function statisticNew()
    {
        return self::where('order_status', self::UN_SHIPMENT)
            ->orderBy('order_time', 'asc')
            ->limit(5)
            ->get();
    }

    /**
     * 商品销量排名，用于仪表盘
     *
     * @param int $date
     * @return int[]
     */
    public static function top(int $date)
    {
        switch($date) {
            case 0:
                $current = Date::today();
                break;
            case 1:
                $current = Date::yesterday();
                break;
            case 2:
                $current = Date::week();
                break;
            case 3:
                $current = Date::beforeWeek(1);
                break;
            case 4:
                $current = Date::month();
                break;
            case 5:
                $current = Date::beforeMonth(1);
                break;
        }
        return OrderGoods::whereHas('order', function (Builder $query) use ($current) {
            $query->whereBetween('order_time',[$current['start'], $current['end']]);
        })
            ->has('goods')
            ->with('goods')
            ->groupBy('goods_id')
            ->select('goods_id', DB::raw('sum(quantity) as quantity'))
            ->orderBy('quantity', 'desc')
            ->get();
    }
}
