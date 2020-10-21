<?php

namespace App\Listeners\Payment;

use App\Events\Payment\SuccessEvent;
use App\Logics\Api\Setting;
use App\Logics\Api\Order;
use App\Models\Payment;

class SuccessEventOrder
{
    public function handle(SuccessEvent $event)
    {
        $payment = $event->payment;

        if ($payment->order_type == Payment::ORDER_TYPE_DEFAULT) {
            $order = Order::with(['goods.goods', 'goods.sku'])->find($payment->order_id);
            $orderSetting = Setting::getInstance('app.order')->fetch();

            foreach ($order->goods as $item) {
                // 是否支付减库存
                if ($orderSetting['stock'] == Setting::STOCK_PLAN_PAYMENT) {
                    $item->goods->sales += $item->quantity; // 销量增加
                    $item->goods->stock -= $item->quantity; // 总库存减少
                    $item->sku->sales += $item->quantity; // Sku销量增加
                    $item->sku->stock -= $item->quantity; // Sku库存减少
                    $item->push();
                }
            }
            $order->payment_time = time();
            $order->payment_status = Order::PAYMENT_STATUS_END;
            $order->order_status = Order::UN_SHIPMENT;
            $order->save();
        }
    }
}
