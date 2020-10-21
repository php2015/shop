<?php

namespace App\Listeners\Payment;

use App\Events\Payment\SuccessEvent;
use App\Logics\Api\Order;
use App\Models\Setting;
use App\Services\Prints\Factory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SuccessEventPrints implements ShouldQueue
{
    public function handle(SuccessEvent $event)
    {
        $payment = $event->payment;
        $setting = Setting::getInstance('prints.base')->fetch();

        if ($setting['status'] == Setting::PRINTS) {
            Factory::getInstance($setting)->prints(Order::detail($payment->order_id));
        }
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
