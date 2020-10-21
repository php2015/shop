<?php

namespace App\Listeners\Order;

use App\Events\Order\SubmitEvent;
use App\Exceptions\AppException;
use App\Logics\Api\Setting;
use App\Logics\Api\User;

class SubmitEventListen
{
    const STOCK_WARN = '库存不足';

    /**
     * 库存处理、销量处理、购物车处理
     * @param SubmitEvent $event
     * @throws AppException
     */
    public function handle(SubmitEvent $event)
    {
        $order = $event->order;
        $list = $order->goods()->with(['goods', 'sku'])->get();
        $setting = Setting::getInstance('app.order')->fetch();

        foreach ($list as $item) {
            if ($item->sku->stock < $item->quantity) {
                throw new AppException(self::STOCK_WARN);
            }

            // 清理购物车
            $order->user->cart()
                ->where('goods_sku_id', $item->sku->id)
                ->delete();

            // 是否下单减库存
            if ($setting['stock'] == Setting::STOCK_PLAN_ORDER) {
                $item->goods->sales += $item->quantity; // 总销量增加
                $item->goods->stock -= $item->quantity; // 总库存减少
                $item->sku->sales += $item->quantity; // Sku销量增加
                $item->sku->stock -= $item->quantity; // Sku库存减少
                $item->push();
            }
        }
    }
}
