<?php

namespace App\Listeners\User;

use App\Events\User\InviteEvent;
use App\Logics\Api\Points;
use App\Models\Setting;
use App\Helper\Date;
use Log;

class InviteEventPoints
{
    public function handle(InviteEvent $event)
    {
        try {
            $setting = Setting::getInstance('market.invite')->fetch();
            $type = isset($setting['type']) ? $setting['type'] : [];

            if (in_array('points', $type)) {
                $month = Date::month();
                $monthSum = Points::whereBetween('record_time',[$month['start'], $month['end']])
                    ->where('user_id', $event->user->parent_id)
                    ->sum('points');

                // 0 为不限制
                if ($setting['points_limit'] === 0) {
                    Points::record($setting['points'], Points::TYPE['INVITE'], $event->user->parent_id);
                } else if ($setting['points_limit'] > $monthSum) {
                    Points::record($setting['points'], Points::TYPE['INVITE'], $event->user->parent_id);
                }
            }
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
