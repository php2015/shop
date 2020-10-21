<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'address';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'contact',
        'phone',
        'province',
        'city',
        'district',
        'detail',
        'num',
        'is_default',
        'lon',
        'lat',
    ];

    // 是否默认地址(10：否、20：是)
    const IS_DEFAULT_OFF = 10;
    const IS_DEFAULT_ON = 20;
}
