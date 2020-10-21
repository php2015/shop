<?php

namespace App\Logics\Api;

use App\Models\Coupon as CouponModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Exceptions\AppException;
use Carbon\Carbon;
use Log;

class Coupon extends CouponModel
{
    const RECEIVE_LIMIT = '只能领取这么多了';
    const RECEIVE_FINISH = '这张优惠卷已被领完了';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });

        static::addGlobalScope('coupon_visible', function (Builder $builder) {
            $builder->where(['coupon_visible' => self::COUPON_VISIBLE_ON]);
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        return self::whereRaw(
            'status = ' .self::STATUS_ON. ' and
            (expire_type=' .self::EXPIRE_TYPE_DYNAMIC. ' or
            (expire_type=' .self::EXPIRE_TYPE_FIXED. ' and end_at > ' . time() . '))')
            ->orderBy('amount', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function receiveing(int $id)
    {
        $user = User::model();
        $model = self::detail($id);
        $count = $user->coupon()
            ->where(['coupon_id' => $id])
            ->count();

        if ($model->total != 0) {
            // 已领完
            if ($model->received >= $model->total) {
                throw new AppException(self::RECEIVE_FINISH);
            }
        }

        // 用户领取上限
        if ($count >= $model->receive_limit) {
            throw new AppException(self::RECEIVE_LIMIT);
        }

        try {
            $receiveModel = new CouponReceive;
            $receiveModel->coupon_name = $model->coupon_name;
            $receiveModel->coupon_type = $model->coupon_type;
            $receiveModel->discount = $model->discount;
            $receiveModel->amount = $model->amount;
            $receiveModel->condition = $model->condition;
            $receiveModel->description = $model->description;
            $receiveModel->url = $model->url;
            $receiveModel->receive_at = time();
            $receiveModel->coupon_id = $id;

            if ($model->expire_type == self::EXPIRE_TYPE_DYNAMIC) { // 领取后生效
                $receiveModel->expire_at = Carbon::now()->addDay($model->expire_at)->timestamp;
            } else { // 固定时间
                $receiveModel->expire_at = strtotime($model->end_at);
            }
            $model->received += 1;
            $model->save();
            return $user->coupon()
                ->save($receiveModel);
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function detail($id)
    {
        return self::findOrFail( $id );
    }

    public static function getDesignCoupon(object $params)
    {
        try {
            $result = [];
            $params = (array) $params;
            $id = array_column($params['coupon'], 'id');

            $list = self::whereRaw(
                'status = ' .self::STATUS_ON. ' and
                (expire_type=' .self::EXPIRE_TYPE_DYNAMIC. ' or
                (expire_type=' .self::EXPIRE_TYPE_FIXED. ' and end_at > ' . time() . '))')
                ->whereIn('id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            foreach($list as $item) {
                // 隐藏已领完的
                if (!($params['hide'] == 20 && $item->total <= $item->received)) {
                    $result[] = $item;
                }
            }
            return $result;
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            return [];
        }
    }
}
