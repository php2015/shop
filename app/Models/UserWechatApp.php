<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class UserWechatApp extends Model
{
    use SoftDeletes;

    protected $table = 'user_wechat_app';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['openid'];
}