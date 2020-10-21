<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    use SoftDeletes;

    protected $table = 'rule';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];

    public function getContentAttribute(string $value)
    {
        return urldecode($value);
    }
}
