<?php

namespace App\Models;

class OrderFetch extends Model
{
    protected $table = 'order_fetch';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'store_address_id',
        'contact',
        'phone',
        'begin_time',
        'end_time',
        'address_name',
        'address',
    ];

    public function getBeginTimeAttribute(int $value)
    {
        return date("Y-m-d H:i", $value);
    }

    public function getEndTimeAttribute(int $value)
    {
        return date("Y-m-d H:i", $value);
    }

    public function address()
    {
        return $this->belongsTo(StoreAddress::class, 'store_address_id');
    }
}