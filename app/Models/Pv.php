<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Pv extends Model
{
    use SoftDeletes;

    protected $table = 'pv';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'client_ip',
        'entry_time',
        'quit_time',
        'user_agent',
    ];

    public function getEntryTimeAttribute($value)
    {
        return date("Y-m-d H:i:s", $value);
    }
}
