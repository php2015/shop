<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderCommentImages extends Model
{
    use SoftDeletes;

    protected $table = 'order_comment_images';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'image',
        'order_comment_id',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($image = $this->getAttribute('image')) {
            if (strpos($image, 'http') === false) {
                $path = config('filesystems.disks.order.comment.path');
                return config('app.url') . $path . $image;
            }
        }
        return $image;
    }
}
