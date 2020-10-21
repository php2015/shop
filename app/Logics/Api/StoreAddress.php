<?php

namespace App\Logics\Api;

use App\Models\StoreAddress as StoreAddressModel;
use Illuminate\Database\Eloquent\Builder;

class StoreAddress extends StoreAddressModel
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    /**
     * 可自提地址列表
     * @return mixed
     */
    public static function getFetch()
    {
        return self::where('is_fetch', self::IS_FETCH_ON)->get();
    }

    /**
     * 可配送地址列表
     * @return mixed
     */
    public static function getShipment()
    {
        return self::where('is_shipment', self::IS_SHIPMENT_ON)->get();
    }

    /**
     * 根据用户坐标返回最近距离的发货点
     *
     * @param float $userLon
     * @param float $userLat
     * @return mixed
     */
    public static function getShipmentMinDistance(float $userLon, float $userLat)
    {
        $result = [];
        // 商家地址库中所有的可发货地址
        $addressList = StoreAddress::getShipment();

        foreach($addressList as $item) {
            // 发货点经纬度
            $storeLon = $item->lon;
            $storeLat = $item->lat;
            // 两点相隔的距离(km)
            $result[] = get_distance($storeLon, $storeLat, $userLon, $userLat);
        }
        return count($result) > 0 ? min($result) : 0;
    }

    /**
     * 根据用户坐标返回自提点并带相隔距离
     *
     * @param float $userLon
     * @param float $userLat
     * @return mixed
     */
    public static function getFetchDistance(float $userLon, float $userLat)
    {
        // 商家地址库中所有的自提地址
        $addressList = StoreAddress::getFetch();
        $setting = Setting::getInstance('logistics.base')->fetch();
        $todayFetch = isset($setting['today_fetch']) ? $setting['today_fetch'] : 20;

        foreach($addressList as $item) {
            // 发货点经纬度
            $storeLon = $item->lon;
            $storeLat = $item->lat;
            // 两点相隔的距离(km)
            $item->distance = get_distance($storeLon, $storeLat, $userLon, $userLat);
            // 获取可上门自提时间
            $item->times = $item->getFetchTime($todayFetch);
        }
        return $addressList;
    }

    /**
     * 获取自提订单的自提预约时间
     *
     * @param int $today_fetch
     * @param string $business_begin
     * @param string $business_end
     * @return mixed
     */
    private function getFetchTime (int $today_fetch)
    {
        $times[] = [
            'text' => '今日',
            'disabled' => false
        ];
        $times[] = [
            'text' => '明日',
            'disabled' => false
        ];
        $id = 1;
        $h = (int) date("H", time());
        if ($this->business == self::BUSINESS_ALL) { // 全天
            $businessBegin = 0;
            $businessEnd = 2400;
        } else {
            $businessBegin = (int) str_replace(':', '', $this->business_begin);
            $businessEnd = (int) str_replace(':', '', $this->business_end);
        }

        foreach ($times as $key => $day) {
            for($i = 0; $i < 24; $i++) {
                // 是否在营业时间段内
                if ($i * 100 >= $businessBegin && $i * 100 < $businessEnd - 30) {
                    if ($key == 0) {
                        $times[$key]['children'][] = [
                            'text' => $i . ':00-' . ($i + 1) . ':00',
                            'id' => $id,
                            'disabled' => !(($today_fetch == Setting::TODAY_FETCH) && $h < $i)
                        ];
                    } else {
                        $times[$key]['children'][] = [
                            'text' => $i . ':00-' . ($i + 1) . ':00',
                            'id' => $id,
                        ];
                    }
                    $id++;
//                    if ($key == 0 && $h < $i) {
//                        $times[$key]['children'][] = [
//                            'text' => $i . ':00-' . ($i + 1) . ':00',
//                            'id' => $id,
//                            'disabled' => $today_fetch != Setting::TODAY_FETCH
//                        ];
//                        $id++;
//                    } else {
//                        $times[$key]['children'][] = [
//                            'text' => $i . ':00-' . ($i + 1) . ':00',
//                            'id' => $id
//                        ];
//                        $id++;
//                    }
                }
            }
        }
        return $times;
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }
}
