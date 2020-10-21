<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StoreEmployee extends Model
{
    use SoftDeletes;

    protected $table = 'store_employee';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'verify',
        'status',
    ];

    // 是否启用(10：否、20：是)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 是否核销人员(10：否、20：是)
    const VERIFY_OFF = 10;
    const VERIFY_ON = 20;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
