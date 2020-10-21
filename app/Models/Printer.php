<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{
    use SoftDeletes;
    
    protected $table = 'printer';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'sn',
        'key',
        'label',
        'copies',
        'status',
        'sort',
    ];

    // 状态(10：下线、20：上线)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;
}
