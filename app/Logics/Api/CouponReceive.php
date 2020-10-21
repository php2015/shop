<?php

namespace App\Logics\Api;

use App\Models\CouponReceive as CouponReceiveModel;
use Illuminate\Http\Request;
use App\Exceptions\AppException;

class CouponReceive extends CouponReceiveModel
{
    const COUPON_WARN = '无效的优惠卷';

    public static function getList()
    {
        $request = Request::capture();
        $status = $request->get('status');
        $filter = [];
        switch($status) {
            case '0':
                $filter[] = ['expire_at', '>', time()];
                $filter[] = ['status', '=', self::STATUS_OFF];
                break;
            case '1':
                $filter[] = ['status', '=', self::STATUS_ON];
                break;
            case '2':
                $filter[] = ['expire_at', '<', time()];
                $filter[] = ['status', '=', self::STATUS_OFF];
                break;
        }

        return User::model()->coupon()
            ->where($filter)
            ->orderBy('amount', 'desc')
            ->orderBy('discount', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 使用优惠卷
     * @param int $id
     * @throws AppException
     */
    public static function use(int $id)
    {
        if ($id > 0) {
            $coupon = User::model()->coupon()
                ->with('coupon')
                ->where(['id' => $id])
                ->where(['status' => self::STATUS_OFF])
                ->first();

            if (empty($coupon)) {
                throw new AppException(self::COUPON_WARN);
            }
            $coupon->status = self::STATUS_ON;
            $coupon->coupon->used += 1;
            $coupon->push();
        }
    }
}
