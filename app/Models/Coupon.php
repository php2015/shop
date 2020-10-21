<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Logics\Admin\CouponReceive;
use Carbon\Carbon;

class Coupon extends Model
{
    use SoftDeletes;

    protected $table = 'coupon';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'coupon_name',
        'coupon_type',
        'coupon_visible',
        'discount',
        'amount',
        'condition',
        'total',
        'expire_type',
        'begin_at',
        'end_at',
        'expire_at',
        'status',
        'receive_limit',
        'description',
        'link',
    ];

    // 状态(10：下线、20：上线)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 优惠卷公开性(10：不公开、20：公开)
    const COUPON_VISIBLE_OFF = 10;
    const COUPON_VISIBLE_ON = 20;

    // 优惠卷类型(10：满减卷、20：折扣券)
    const COUPON_TYPE_MINUS = 10;
    const COUPON_TYPE_DISCOUNT = 20;

    // 到期类型(10：领取后生效、20：固定时间)
    const EXPIRE_TYPE_DYNAMIC = 10;
    const EXPIRE_TYPE_FIXED = 20;

    // 优惠卷发放类型
    const COUPON_ISSUE_SELECT = 10; // 选择用户
    const COUPON_ISSUE_NEW = 20; // 新用户
    const COUPON_ISSUE_OLD = 30; // 老用户

//    protected $dates = [
//        'seen_at',
//    ];

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

    public function getBeginAtAttribute($value)
    {
        return $value ? date("Y-m-d", $value) : '';
    }

    public function setBeginAtAttribute(string $value)
    {
        $this->attributes['begin_at'] = strtotime($value);
    }

    public function getEndAtAttribute($value)
    {
        return $value ? date("Y-m-d", $value) : '';
    }

    public function setEndAtAttribute(string $value)
    {
        $this->attributes['end_at'] = strtotime($value);
    }

    public function receive()
    {
        return $this->hasMany(CouponReceive::class);
    }

    /**
     * 推送优惠卷给用户
     *
     * @param Coupon $coupon
     * @param User $user
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public static function give(Coupon $coupon, User $user)
    {
        $receive = new CouponReceive;
        $receive->user_id = $user->id;
        $receive->coupon_name = $coupon->coupon_name;
        $receive->coupon_type = $coupon->coupon_type;
        $receive->discount = $coupon->discount;
        $receive->amount = $coupon->amount;
        $receive->condition = $coupon->condition;
        $receive->source = CouponReceive::COUPON_SOURCE_ISSUE;
        $receive->receive_at = time();

        if ($coupon->expire_type == self::EXPIRE_TYPE_DYNAMIC) { // 领取后生效
            $receive->expire_at = Carbon::now()->addDay($coupon->expire_at)->timestamp;
        } else { // 固定时间
            $receive->expire_at = strtotime($coupon->end_at);
        }
        $coupon->received += 1;
        $coupon->save();
        return $coupon->receive()
            ->save($receive);
    }
}
