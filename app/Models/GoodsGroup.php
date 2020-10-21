<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsGroup extends Model
{
    use SoftDeletes;

    protected $table = 'goods_group';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'group_name',
        'sort',
        'status',
    ];

    // 状态(10：下线、20：上线)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    /**
     * 关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function goods()
    {
        return $this->belongsToMany(
            Goods::class,
            'goods_group_pivot',
            'group_id',
            'goods_id'
        );
    }
}
