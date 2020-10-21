<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $table = 'admin';

    protected $hidden = ['password', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'username',
        'realname',
        'gender',
        'avatar',
        'email',
        'phone',
        'intro',
    ];

    protected $casts = [];

    protected $appends = ['avatar_url'];

    // 是否禁用(10: 未禁用、20：已禁用)
    const DISABLE_OFF = 10;
    const DISABLE_ON = 20;

    public function getAvatarUrlAttribute()
    {
        if ($avatar = $this->getAttribute('avatar')) {
            if (strpos($avatar, 'http') === false) {
                $path = config('filesystems.disks.console.avatar.path');
                return config('app.url') . $path . $avatar;
            }
        }
        return $avatar;
    }

    public function getLastLoginTimeAttribute(int $value)
    {
        return !empty($value)
            ? date("Y-m-d H:i:s", $value)
            : '';
    }

    /**
     * 关联到角色，用于列表显示
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
