<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class LocalTemplateItem extends Model
{
    use SoftDeletes;

    protected $table = 'local_template_item';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'min',
        'max',
        'fee',
    ];

    public function getFeeAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setFeeAttribute(float $value)
    {
        $this->attributes['fee'] = bcmul($value, 100);
    }
}
