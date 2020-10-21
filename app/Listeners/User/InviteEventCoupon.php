<?php

namespace App\Listeners\User;

use App\Events\User\InviteEvent;
use App\Models\Setting;
use App\Models\Coupon;
use App\Models\User;
use Log;

class InviteEventCoupon
{
    public function handle(InviteEvent $event)
    {
        try {
            $setting = Setting::getInstance('market.invite')->fetch();
            $type = isset($setting['type']) ? $setting['type'] : [];

            if (in_array('coupon', $type)) {
                foreach ($setting['coupon'] as $item) {
                    // 恐怕已被删除
                    if ($coupon = Coupon::find($item->id)) {
                        $user = User::find($event->user->parent_id);
                        Coupon::give($coupon, $user);
                    }
                }
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
