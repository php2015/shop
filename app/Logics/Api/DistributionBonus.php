<?php

namespace App\Logics\Api;

use App\Models\DistributionBonus as DistributionBonusModel;
use Carbon\Carbon;

class DistributionBonus extends DistributionBonusModel
{
    /**
     * 支出、提现
     * @return mixed
     */
    public static function expenses()
    {
        $sum = User::model()->bonus()->where('amount', '<', 0)->sum('amount');
        return $sum == 0 ? 0 : bcdiv($sum, 100, 2);
    }

    /**
     * 收入、提成
     * @return mixed
     */
    public static function income()
    {
        $sum = User::model()->bonus()->where('amount', '>', 0)->sum('amount');
        return $sum == 0 ? 0 : bcdiv($sum, 100, 2);
    }

    /**
     * 未到期，到指定时间之后解锁
     * @return mixed
     */
    public static function delay()
    {
        $cash_lock = 0;
        if ($setting = Setting::getInstance('finance.cash')->fetch()) {
            $cash_lock = $setting['cash_lock'];
        }

        $sum = User::model()
            ->bonus()
            ->where('amount', '>', 0)
            ->where('record_time', '>', Carbon::now('Asia/shanghai')->modify('-'.$cash_lock.' days')->timestamp)
            ->sum('amount');
        return $sum == 0 ? 0 : bcdiv($sum, 100, 2);
    }
}
