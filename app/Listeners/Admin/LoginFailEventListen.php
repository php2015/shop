<?php

namespace App\Listeners\Admin;

use App\Events\Admin\LoginFailEvent;
use App\Logics\Admin\AdminLog;
use App\Logics\Admin\Setting;

class LoginFailEventListen
{
    public function handle(LoginFailEvent $event)
    {
        // 记录登录日志
        AdminLog::write($event->admin, AdminLog::STATUS_FAIL);

        $lock = Setting::LOCK;
        $limitedTimeLength = 15;
        $failTimes = 3;
        $lockTimeLength = 10;

        if ($setting = Setting::getInstance('system.security')->fetch()) {
            $lock = $setting['lock'];
            $limitedTimeLength = $setting['limited_time_length'];
            $failTimes = $setting['fail_times'];
            $lockTimeLength = $setting['lock_time_length'];
        }

        if ($lock == Setting::LOCK) {
            $fails = AdminLog::fails($event->admin, $limitedTimeLength);

            // 锁定账号
            if ($fails >= $failTimes) {
                $event->admin->lock_time = time() + $lockTimeLength * 60;
                $event->admin->save();
            }
        }
    }
}
