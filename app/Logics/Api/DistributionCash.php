<?php

namespace App\Logics\Api;

use App\Models\DistributionCash as DistributionCashModel;
use App\Exceptions\AppException;
use App\Models\Setting;
use Illuminate\Http\Request;
use DB;

class DistributionCash extends DistributionCashModel
{
    const CASH_LIMIT_ERROR = '提现金额未达到提现门槛金额';
    const AMOUNT_ERROR = '提现金额大于可提现金额';
    const FEE_ERROR = '提现手续费设置错误';

    public static function getList()
    {
        $request = Request::capture();
        $status = $request->get('status');
        $filter = [];
        switch($status) {
            case '0':
                $filter[] = ['cash_status', '=', self::CASH_STATUS_APPLY];
                break;
            case '1':
                $filter[] = ['cash_status', '=', self::CASH_STATUS_FINISH];
                $filter[] = ['audit_status', '=', self::AUDIT_STATUS_PASS];
                break;
            case '2':
                $filter[] = ['cash_status', '=', self::CASH_STATUS_FINISH];
                $filter[] = ['audit_status', '=', self::AUDIT_STATUS_FAIL];
                break;
        }

        return User::model()->cash()
            ->where($filter)
            ->orderBy('cash_time', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 提现申请
     * @param float $amount
     * @return bool
     * @throws AppException
     */
    public static function apply(float $amount)
    {
        try {
            $setting = Setting::getInstance('finance.cash')->fetch();
            $user = User::model();
            $delay = DistributionBonus::delay();
            $amount = $amount * 100;
            $cash_limit = $setting['cash_limit'] * 100; // 最低提现金额
            $cash_fee = $setting['cash_fee'] * 100; // 提现手续费
            $bonus = $user->bonus * 100 - $delay * 100; //可提现金额 = 余额 - 未到期金额

            if ($cash_limit > $amount) {
                throw new AppException(self::CASH_LIMIT_ERROR);
            }

            if ($bonus < $amount) {
                throw new AppException(self::AMOUNT_ERROR);
            }

            // 10: 百分比 20： 固定金额
            switch($setting['cash_fee_type']) {
                case Setting::CASH_FEE_TYPE_PERCENTAGE:
                    $cash_fee = $amount * ($cash_fee / 10000);
                    $payment = $amount - $cash_fee;
                    break;

                case Setting::CASH_FEE_TYPE_FIXED:
                    $payment = $amount - $cash_fee;
                    // 申请提现的金额 - 手续费 小于 0 就出错了。
                    if ($payment <= 0) {
                        throw new AppException(self::FEE_ERROR);
                    }
                    break;
            }

            $cash = new DistributionCash;
            $cash->cash_no = self::cashNo();
            $cash->cash_time = time();
            $cash->cash_channel = self::CASH_CHANNEL_WECHAT;
            $cash->client_ip = get_client_ip();
            $cash->cash_apply = $amount / 100;
            $cash->cash_fee = $cash_fee / 100;
            $cash->cash_amount = $payment / 100;

            DB::beginTransaction();
            $user->cash()->save($cash);
            $user->bonus -= $cash->cash_apply;
            $user->save();
            DB::commit();
            return true;
        } catch (\Exctption $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    /**
     * 获取订单编号
     * @return string
     */
    protected static function cashNo()
    {
        return date('Ymd') .
            substr(
                implode(NULL,
                    array_map('ord',
                        str_split(
                            substr(uniqid(), 7, 13),
                            1)
                    )
                ), 0, 8
            );
    }
}
