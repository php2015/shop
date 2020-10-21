<?php

namespace App\Listeners\Payment;

use App\Events\Payment\SuccessEvent;
use App\Models\Setting;
use App\Services\Message\Factory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SuccessEventSms implements ShouldQueue
{
    public function handle(SuccessEvent $event)
    {
        $setting = Setting::getInstance('message.sms')->fetch();
        $orderSetting = Setting::getInstance('app.order')->fetch();
        Factory::getInstance($setting)->template('NEW_ORDER')->send($orderSetting['sms_receiver'], []);
    }

    /**
     * 处理失败任务。
     *
     * @param SuccessEvent $event
     * @param \Exception $exception
     */
    public function failed(SuccessEvent $event, \Exception $exception)
    {
        Log::error($exception->getTraceAsString() . PHP_EOL);
    }
}
