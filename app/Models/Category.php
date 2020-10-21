<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'category';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'category_name',
        'image',
        'sort',
        'status',
        'level',
        'parent_id',
    ];

    protected $appends = ['image_url'];

    // 状态(10：下线、20：上线)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    public function getImageUrlAttribute()
    {
        if ($image = $this->getAttribute('image')) {
            if (strpos($image, 'http') === false) {
                $path = config('filesystems.disks.goods.category.path');
                return config('app.url') . $path . $image;
            }
        }
        return $image;
    }

    public function goods()
    {
        return $this->hasMany(Goods::class);
    }
}
