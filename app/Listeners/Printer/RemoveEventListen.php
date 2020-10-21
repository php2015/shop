<?php

namespace App\Listeners\Printer;

use App\Events\Printer\RemoveEvent;
use App\Exceptions\AppException;
use App\Logics\Admin\Setting;
use App\Services\Prints\Factory;

class RemoveEventListen
{
    public function handle(RemoveEvent $event)
    {
        $printer = $event->printer;
        $setting = Setting::getInstance('prints.base')->fetch();
        if (Factory::getInstance($setting)->remove($printer) !== true) {
            throw new AppException('删除打印机失败');
        }
    }
}
