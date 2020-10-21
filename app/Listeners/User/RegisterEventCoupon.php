<?php

namespace App\Listeners\User;

use App\Events\User\RegisterEvent;
use App\Models\Coupon;
use App\Models\Setting;
use Log;

class RegisterEventCoupon
{
    public function handle(RegisterEvent $event)
    {
        try {
            $setting = Setting::getInstance('market.register')->fetch();
            $type = isset($setting['type']) ? $setting['type'] : [];

            if (in_array('coupon', $type)) {
                foreach ($setting['coupon'] as $item) {
                    // 恐怕已被删除
                    if ($coupon = Coupon::find($item->id)) {
                        Coupon::give($coupon, $event->user);
                    }
                }
            }
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
