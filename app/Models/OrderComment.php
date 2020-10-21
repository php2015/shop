<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderComment extends Model
{
    use SoftDeletes;

    protected $table = 'order_comment';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [
        'order_id',
        'goods_id',
        'user_id'
    ];

    public function getCommentTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getReplyTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    /**
     * 关联回复的图片
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(OrderCommentImages::class);
    }

    /**
     * 反向关联到用户表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 反向关联到商品表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
