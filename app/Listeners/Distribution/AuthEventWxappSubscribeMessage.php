<?php

namespace App\Listeners\Distribution;

use App\Events\Distribution\AuthEvent;
use App\Models\Distribution;
use App\Services\Message\Factory;
use App\Models\Setting;
use Log;

class AuthEventWxappSubscribeMessage
{
    public function handle(AuthEvent $event)
    {
        $openid = $event->distribution->user->wxapp->openid;
        $data = [
            'phrase2' => [
                'value' => $event->distribution->audit_status == Distribution::AUDIT_STATUS_PASS ? '已通过' : '未通过',
            ],
            'date3' => [
                'value' => $event->distribution->apply_time,
            ],
            'date1' => [
                'value' => $event->distribution->audit_time,
            ],
            'thing4' => [
                'value' => empty($event->distribution->remark) ? '无' : $event->distribution->remark,
            ],
        ];
        $setting = Setting::getInstance('message.wxapp')->fetch();
        Factory::getInstance($setting)->template('DISTRIBUTION_AUTH')->send($openid, $data);
    }

    /**
     * 处理失败任务。
     *
     * @param AuthEvent $event
     * @param \Exception $exception
     */
    public function failed(AuthEvent $event, \Exception $exception)
    {
        Log::error($exception->getTraceAsString() . PHP_EOL);
    }
}
