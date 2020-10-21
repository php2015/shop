<?php

namespace App\Listeners\Order;

use App\Events\Order\ReceiveEvent;
use App\Logics\Api\Points;

class ReceiveEventPoints
{
    /**
     * 签收后积分增加
     * @param ReceiveEvent $event
     */
    public function handle(ReceiveEvent $event)
    {
        $order = $event->order;
        $list = $order->goods()->with(['sku'])->get();

        foreach ($list as $item) {
            Points::record($item->sku->points, Points::TYPE['ORDER'], $order->user_id);
        }
    }
}
