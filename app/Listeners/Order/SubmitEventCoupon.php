<?php

namespace App\Listeners\Order;

use App\Events\Order\SubmitEvent;
use App\Logics\Api\CouponReceive;

class SubmitEventCoupon
{
    public function handle(SubmitEvent $event)
    {
        CouponReceive::use($event->order->coupon_receive_id);
    }
}
