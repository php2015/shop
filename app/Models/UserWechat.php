<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class UserWechat extends Model
{
    use SoftDeletes;

    protected $table = 'user_wechat';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['openid'];
}