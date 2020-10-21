<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Checkin extends Model
{
    use SoftDeletes;

    protected $table = 'checkin';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [
        'user_id'
    ];
}
