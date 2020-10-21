<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Points extends Model
{
    use SoftDeletes;

    protected $table = 'points';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [
        'user_id'
    ];

    // 状态(10：关闭、20：开启)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 积分奖励类型
    const TYPE = [
        'REGISTER' => '新用户注册',
        'CHECKIN' => '签到',
        'ORDER' => '购买商品',
        'INVITE' => '邀请新用户',
    ];

    public function getRecordTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }
}
