<?php

namespace App\Models;

class Module extends Model
{
    protected $table = 'module';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'module_name',
        'parent_id',
        'icon',
        'client_router',
        'server_router',
        'level',
        'extend',
        'hide',
        'sort',
        'intro',
    ];

    const LEVEL_ERROR = '最多只能添加3级';
    const PARENT_ERROR = '不能选择自己为上级';

    // 是否权限继承(10：否、20：是 )
    const EXTEND_OFF = 10;
    const EXTEND_ON = 20;

    // 模块类型(10：目录、20：菜单、30：权限)
    const LEVEL_DIR = 10;
    const LEVEL_MENU = 20;
    const LEVEL_POWER = 30;

    public function roleModule()
    {
        return $this->hasMany(RoleModule::class);
    }

//    public function allChildren() {
//        return $this->hasMany(get_class($this), 'parent_id' )->orderBy('sort', 'asc');
//    }
//
//    public function children() {
//        return $this->allChildren()->with( 'children' );
//    }
}
