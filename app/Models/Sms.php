<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{
    use SoftDeletes;

    protected $table = 'sms';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'phone',
        'code',
        'send_time',
        'expire_time',
    ];

    // 使用状态(10：未使用、20：已使用)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;
}
