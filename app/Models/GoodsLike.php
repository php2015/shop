<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsLike extends Model
{
    use SoftDeletes;

    protected $table = 'goods_like';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [
        'user_id'
    ];

    /**
     * 反向关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class)
            ->where('status', 20);
    }
}
