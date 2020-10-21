<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsSupportPivot extends Model
{
    use SoftDeletes;

    protected $table = 'goods_support_pivot';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'goods_id',
        'support_id',
    ];
}
