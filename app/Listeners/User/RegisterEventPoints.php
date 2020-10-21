<?php

namespace App\Listeners\User;

use App\Events\User\RegisterEvent;
use App\Logics\Api\Points;
use App\Models\Setting;
use Log;

class RegisterEventPoints
{
    public function handle(RegisterEvent $event)
    {
        try {
            $setting = Setting::getInstance('market.register')->fetch();
            $type = isset($setting['type']) ? $setting['type'] : [];

            if (in_array('points', $type)) {
                Points::record($setting['points'], Points::TYPE['REGISTER'], $event->user->id);
            }
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
