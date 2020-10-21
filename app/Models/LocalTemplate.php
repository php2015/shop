<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class LocalTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'local_template';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'name',
        'free',
        'method',
        'distance',
        'weight',
        'sort',
    ];

    // 是否包邮(10：不包邮、20：包邮)
    const LOGISTICS_FREE_OFF = 10;
    const LOGISTICS_FREE_ON = 20;

    // 计价方式(10：按距离、20：按重量)
    const METHOD_DISTANCE = 10;
    const METHOD_WEIGHT = 20;

    public function item()
    {
        return $this->hasMany(LocalTemplateItem::class);
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
