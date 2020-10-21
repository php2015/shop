<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderInvoice extends Model
{
    use SoftDeletes;

    protected $table = 'order_invoice';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'category',
        'title',
        'tax_no',
        'bank_name',
        'bank_account',
        'phone',
        'email',
    ];

    // 处理状态(10：未开票、20：已开票)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    public function getTaxAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setTaxAttribute(float $value)
    {
        $this->attributes['tax'] = bcmul($value, 100);
    }

    public function getIssueTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
