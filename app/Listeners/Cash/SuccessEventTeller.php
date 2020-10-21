<?php

namespace App\Listeners\Cash;

use App\Events\Cash\SuccessEvent;
use App\Exceptions\AppException;
use App\Logics\Admin\User;
use App\Logics\Admin\Payment;
use App\Models\DistributionBonus;
use App\Services\Payment\Factory;

class SuccessEventTeller
{
    public function handle(SuccessEvent $event)
    {
        $cash = $event->cash;
        $user = User::detail($cash->user_id);

        $factory = Factory::getInstance([
            'cash_no' => $cash->cash_no,
            'amount' => $cash->cash_amount,
            'openid' => $user->openid,
            'payment_channel' => Payment::PAYMENT_CHANNEL_TRANSFER
        ]);

        if ($return = $factory->payment()) {
            $response = $factory->getResponse();
            $cash->payment_no = $response->payment_no;
            $cash->save();

            $record = new DistributionBonus;
            $record->order_id = $cash->id;
            $record->amount = -$cash->cash_apply;
            $record->balance = $user->bonus;
            $record->record_time = time();
            $user->bonus()->save($record);
        } else {
            throw new AppException('提现失败');
        }
    }
}
