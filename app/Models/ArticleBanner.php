<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleBanner extends Model
{
    use SoftDeletes;

    protected $table = 'article_banner';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'title',
        'image',
        'redirect_type',
        'redirect_site',
        'status',
        'sort',
    ];

    protected $appends = ['image_url'];

    // 状态(10：下线、20：上线)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 是否跳转(10：不跳转、20：跳转)
    const REDIRECT_TYPE_OFF = 10;
    const REDIRECT_TYPE_ON = 20;

    public function getImageUrlAttribute()
    {
        if ($image = $this->getAttribute('image')) {
            if (strpos($image, 'http') === false) {
                $path = config('filesystems.disks.article.banner.path');
                return config('app.url') . $path . $image;
            }
        }
        return $image;
    }
}