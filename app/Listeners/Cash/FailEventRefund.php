<?php

namespace App\Listeners\Cash;

use App\Events\Cash\FailEvent;
use App\Logics\Admin\User;

class FailEventRefund
{
    /**
     * 审核未通过、提现金额返还回用户账户余额
     * @param FailEvent $event
     */
    public function handle(FailEvent $event)
    {
        $cash = $event->cash;
        $user = User::detail($cash->user_id);
        $user->bonus += $cash->cash_apply;
        $user->save();
    }
}
