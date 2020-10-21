<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $table = 'store';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'store_name',
        'contact',
        'phone',
        'business',
        'business_begin',
        'business_end',
        'province',
        'city',
        'district',
        'lon',
        'lat',
        'address',
        'sort',
        'status',
        'intro',
    ];

    // 状态(10：下线、20：上线)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    public function getBusinessBeginAttribute(int $value)
    {
        if ($value == 0) {
            $value = '0000';
        } else if ($value < 1000) {
            $value = '0' . $value;
        } else {
            $value = $value . '';
        }
        $h = substr($value, 0, 2);
        $m = substr($value, 2);
        return $h.':'.$m;
    }

    public function setBusinessBeginAttribute(string $value)
    {
        $this->attributes['business_begin'] = (int) str_replace(':', '', $value);
    }

    public function getBusinessEndAttribute(int $value)
    {
        if ($value == 0) {
            $value = '0000';
        } else if ($value < 1000) {
            $value = '0' . $value;
        } else {
            $value = $value . '';
        }
        $h = substr($value, 0, 2);
        $m = substr($value, 2);
        return $h.':'.$m;
    }

    public function setBusinessEndAttribute(string $value)
    {
        $this->attributes['business_end'] = (int) str_replace(':', '', $value);
    }
}
