<?php

namespace App\Listeners\Printer;

use App\Events\Printer\AddEvent;
use App\Exceptions\AppException;
use App\Logics\Admin\Setting;
use App\Services\Prints\Factory;

class AddEventListen
{
    public function handle(AddEvent $event)
    {
        $printer = $event->printer;
        $setting = Setting::getInstance('prints.base')->fetch();
        if (Factory::getInstance($setting)->add($printer) !== true) {
            throw new AppException('添加打印机失败');
        }
    }
}
