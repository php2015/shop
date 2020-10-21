<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'invoice';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [
        'user_id'
    ];

    // 发票抬头(10：个人、20：单位)
    const CATEGORY_PERSON = 10;
    const CATEGORY_COMPANY = 20;
}
