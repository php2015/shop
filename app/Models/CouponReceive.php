<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CouponReceive extends Model
{
    use SoftDeletes;

    protected $table = 'coupon_receive';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [
        'user_id'
    ];

    // 状态(10：未使用、20：已使用)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 优惠卷类型(10：满减卷、20：折扣券)
    const COUPON_TYPE_MINUS = 10;
    const COUPON_TYPE_DISCOUNT = 20;

    // 优惠卷来源(10：主动领取、20：系统发放)
    const COUPON_SOURCE_RECEIVE = 10;
    const COUPON_SOURCE_ISSUE = 20;

    public function getAmountAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setAmountAttribute(float $value)
    {
        $this->attributes['amount'] = bcmul($value, 100);
    }

    public function getConditionAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setConditionAttribute(float $value)
    {
        $this->attributes['condition'] = bcmul($value, 100);
    }

    public function getExpireAtAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getReceiveAtAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getUseAtAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    /**
     * 反向关联到用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 反向关联到优惠卷
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
