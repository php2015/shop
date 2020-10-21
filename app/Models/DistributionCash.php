<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class DistributionCash extends Model
{
    use SoftDeletes;

    protected $table = 'distribution_cash';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [];

    // 支付状态(10：未支付、20：已支付)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 审核状态(10：未通过、20：通过)
    const AUDIT_STATUS_FAIL = 10;
    const AUDIT_STATUS_PASS = 20;

    // 提现状态(10：申请、20：完成)
    const CASH_STATUS_APPLY = 10;
    const CASH_STATUS_FINISH = 20;

    // 提现渠道(10：账户余额、20：微信)
    const CASH_CHANNEL_ACCOUNT = 10;
    const CASH_CHANNEL_WECHAT = 20;

    public function getCashTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getFinishTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getCashFeeAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setCashFeeAttribute(float $value)
    {
        $this->attributes['cash_fee'] = bcmul($value, 100);
    }

    public function getCashApplyAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setCashApplyAttribute(float $value)
    {
        $this->attributes['cash_apply'] = bcmul($value, 100);
    }

    public function getCashAmountAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setCashAmountAttribute(float $value)
    {
        $this->attributes['cash_amount'] = bcmul($value, 100);
    }

    /**
     * 反向关联到用户表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
