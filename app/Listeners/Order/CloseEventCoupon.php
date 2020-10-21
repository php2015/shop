<?php

namespace App\Listeners\Order;

use App\Events\Order\CloseEvent;
use App\Logics\Api\CouponReceive;

class CloseEventCoupon
{
    /**
     * 返还优惠卷
     *
     * @param  CloseEvent  $event
     * @return void
     */
    public function handle(CloseEvent $event)
    {
        $order = $event->order;
        $coupon_id = $order->coupon_receive_id;

        if ($coupon_id > 0) {
            $couponReceive = CouponReceive::with('coupon')->findOrFail($coupon_id);
            $couponReceive->status = 10;
            $couponReceive->coupon->used -= 1;
            $couponReceive->push();
        }
    }
}
