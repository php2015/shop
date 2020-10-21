<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'article';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];

    protected $appends = ['image_url'];

    // 状态(10：下线、20：上线)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 是否推荐(10：否、20：是)
    const IS_BEST_OFF = 10;
    const IS_BEST_NO = 20;

    public function getImageUrlAttribute()
    {
        if ($image = $this->getAttribute('image')) {
            if (strpos($image, 'http') === false) {
                $path = config('filesystems.disks.article.image.path');
                return config('app.url') . $path . $image;
            }
        }
        return $image;
    }

    public function getReleaseTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d", $value) : '';
    }

    public function getContentAttribute(string $value)
    {
        return urldecode($value);
    }

    /**
     * 关联到分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }
}
