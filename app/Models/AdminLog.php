<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class AdminLog extends Model
{
    use SoftDeletes;

    protected $table = 'admin_log';

    protected $hidden = ['account_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_agent',
        'client_ip',
        'login_time',
    ];

    // 状态(10：失败、20：成功)
    const STATUS_FAIL = 10;
    const STATUS_SUCCESS = 20;

    public function getLoginTimeAttribute($value)
    {
        return date("Y-m-d H:i:s", $value);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
