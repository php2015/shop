<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsGroupPivot extends Model
{
    use SoftDeletes;

    protected $table = 'goods_group_pivot';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'goods_id',
        'group_id',
    ];
}
