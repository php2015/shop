<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Distribution extends Model
{
    use SoftDeletes;

    protected $table = 'distribution';

    protected $hidden = ['user_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'apply_status',
        'audit_status',
        'apply_time',
        'audit_time',
    ];

    // 申请状态(10：申请、20：完成)
    const APPLY_STATUS_BEGIN = 10;
    const APPLY_STATUS_FINISH = 20;

    // 审核状态(10：未通过、20：通过)
    const AUDIT_STATUS_FAIL = 10;
    const AUDIT_STATUS_PASS = 20;

    public function getApplyTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getAuditTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}