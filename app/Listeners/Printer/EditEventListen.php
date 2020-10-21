<?php

namespace App\Listeners\Printer;

use App\Events\Printer\EditEvent;
use App\Exceptions\AppException;
use App\Logics\Admin\Setting;
use App\Services\Prints\Factory;

class EditEventListen
{
    public function handle(EditEvent $event)
    {
        $printer = $event->printer;
        $setting = Setting::getInstance('prints.base')->fetch();
        if (Factory::getInstance($setting)->edit($printer) !== true) {
            throw new AppException('修改打印机失败');
        }
    }
}
