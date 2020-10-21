<?php

namespace App\Listeners\Order;

use App\Events\Order\ShipmentEvent;
use App\Models\Order;
use App\Models\Setting;
use App\Services\Message\Factory;

class ShipmentEventWxappSubscribeMessage
{
    /**
     * 发送小程序模板消息
     *
     * @param  ShipmentEvent  $event
     * @return void
     */
    public function handle(ShipmentEvent $event)
    {
        $order = $event->order;
        // 自提订单发货不发送
        if ($order->logistics_method != Order::LOGISTICS_METHOD_FETCH) {
            $order = $order::detail($order->id);
            $goods = $order->goods;
            $logistics = $order->logistics;
            $openid = $order->user->wxapp->openid;
            $data = [
                'character_string1' => [
                    'value' => $order->order_no,
                ],
                'thing6' => [
                    'value' => $goods[0]->goods_name . '等' . count($goods) . '件商品',
                ],
                'thing20' => [
                    'value' => $logistics->express->company,
                ],
                'character_string5' => [
                    'value' => $logistics->express_no ? $logistics->express_no : '-',
                ],
                'thing7' => [
                    'value' => $logistics->province . $logistics->city . $logistics->district . $logistics->detail,
                ],
            ];
            $setting = Setting::getInstance('message.wxapp')->fetch();
            Factory::getInstance($setting)->template('ORDER_SHIPMENT')->send($openid, $data);
        }
    }
}
