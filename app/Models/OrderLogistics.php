<?php

namespace App\Models;

class OrderLogistics extends Model
{
    protected $table = 'order_logistics';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'contact',
        'phone',
        'province',
        'city',
        'district',
        'detail',
        'num',
        'lon',
        'lat',
    ];

    /**
     * 反向关联到快递公司表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function express()
    {
        return $this->belongsTo(Express::class, 'express_id');
    }
}
