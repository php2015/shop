<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 登录
        'App\Events\Admin\LoginFailEvent' => [
            'App\Listeners\Admin\LoginFailEventListen',
        ],
        'App\Events\Admin\LoginSuccessEvent' => [
            'App\Listeners\Admin\LoginSuccessEventListen',
        ],
        // 用户
        'App\Events\User\RegisterEvent' => [
            'App\Listeners\User\RegisterEventPoints',
            'App\Listeners\User\RegisterEventCoupon',
        ],
        'App\Events\User\InviteEvent' => [
            'App\Listeners\User\InviteEventRelation',
            'App\Listeners\User\InviteEventPoints',
            'App\Listeners\User\InviteEventCoupon',
        ],
        // 订单
        'App\Events\Order\SubmitEvent' => [
            'App\Listeners\Order\SubmitEventCoupon',
            'App\Listeners\Order\SubmitEventListen',
        ],
        'App\Events\Order\ReceiveEvent' => [
            'App\Listeners\Order\ReceiveEventPoints',
            'App\Listeners\Order\ReceiveEventDistribution',
        ],
        'App\Events\Order\CloseEvent' => [
            'App\Listeners\Order\CloseEventGoods',
            'App\Listeners\Order\CloseEventCoupon',
        ],
        'App\Events\Order\ShipmentEvent' => [
            'App\Listeners\Order\ShipmentEventWxappSubscribeMessage',
        ],
        // 支付
        'App\Events\Payment\SuccessEvent' => [
            'App\Listeners\Payment\SuccessEventOrder',
            'App\Listeners\Payment\SuccessEventSms',
            'App\Listeners\Payment\SuccessEventPrints',
        ],
        // 提现
        'App\Events\Cash\SuccessEvent' => [
            'App\Listeners\Cash\SuccessEventTeller',
        ],
        'App\Events\Cash\FailEvent' => [
            'App\Listeners\Cash\FailEventRefund',
        ],
        // 打印机
        'App\Events\Printer\AddEvent' => [
            'App\Listeners\Printer\AddEventListen',
        ],
        'App\Events\Printer\EditEvent' => [
            'App\Listeners\Printer\EditEventListen',
        ],
        'App\Events\Printer\RemoveEvent' => [
            'App\Listeners\Printer\RemoveEventListen',
        ],
        // 商品点击
        'App\Events\Goods\ViewEvent' => [
            'App\Listeners\Goods\ViewEventCount',
            'App\Listeners\Goods\ViewEventHistory',
        ],
        // 优惠卷
        'App\Events\Coupon\IssueEvent' => [
            'App\Listeners\Coupon\IssueEventMessage',
        ],
        // 分销商
        'App\Events\Distribution\AuthEvent' => [
            'App\Listeners\Distribution\AuthEventWxappSubscribeMessage',
        ],
    ];

    protected $subscribe = [];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
