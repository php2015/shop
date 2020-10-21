<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class UserTag extends Model
{
    use SoftDeletes;

    protected $table = 'user_tag';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'tag_name',
        'sort',
        'intro',
    ];

    public function user()
    {
        return $this->belongsToMany(
            User::class,
            'user_tag_pivot',
            'tag_id',
            'user_id'
        );
    }
}
