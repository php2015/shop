<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StoreAddress extends Model
{
    use SoftDeletes;

    protected $table = 'store_address';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'address_name',
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
        'is_fetch',
        'is_shipment'
    ];

    // 是否启用(10：否、20：是)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 营业时间(10：全天、20：自定)
    const BUSINESS_ALL = 10;
    const BUSINESS_SELECT = 20;

    // 是否自提地址(10：否、20：是)
    const IS_FETCH_OFF = 10;
    const IS_FETCH_ON = 20;

    // 是否发货地址(10：否、20：是)
    const IS_SHIPMENT_OFF = 10;
    const IS_SHIPMENT_ON = 20;

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
