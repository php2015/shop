<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $table = 'payment';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [
        'user_id'
    ];

    // 支付状态(10：未支付、20：已支付)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 支付类型(10：钱包、20：微信、30：提现)
    const PAYMENT_CHANNEL_ACCOUNT = 10;
    const PAYMENT_CHANNEL_WECHAT = 20;
    const PAYMENT_CHANNEL_TRANSFER = 30;

    // 订单类型(10：普通订单、20：秒杀订单)
    const ORDER_TYPE_DEFAULT = 10;
    const ORDER_TYPE_MIAOSHA = 20;

    public function getPaymentPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setPaymentPriceAttribute(float $value)
    {
        $this->attributes['payment_price'] = bcmul($value, 100);
    }

    public function getPaymentTimeAttribute(int $value)
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
}
