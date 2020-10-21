<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class DistributionBonus extends Model
{
    use SoftDeletes;

    protected $table = 'distribution_bonus';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [];

    public function getAmountAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setAmountAttribute(float $value)
    {
        $this->attributes['amount'] = bcmul($value, 100);
    }

    public function getBalanceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setBalanceAttribute(float $value)
    {
        $this->attributes['balance'] = bcmul($value, 100);
    }

    public function getRecordTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    /**
     * 反向关联到订单表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
}
