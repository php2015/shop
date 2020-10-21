<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use SoftDeletes;

    protected $table = 'article_category';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];

    // 状态(10：下线、20：上线)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;
}
