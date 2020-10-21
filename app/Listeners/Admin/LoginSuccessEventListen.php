<?php

namespace App\Listeners\Admin;

use App\Events\Admin\LoginSuccessEvent;
use App\Exceptions\AppException;
use App\Logics\Admin\AdminLog;
use App\Logics\Admin\Role;
use App\Models\Module;
use Illuminate\Http\Request;
use Cache;

class LoginSuccessEventListen
{
    public function handle(LoginSuccessEvent $event)
    {
        // 记录登录日志
        AdminLog::write($event->admin, AdminLog::STATUS_SUCCESS);

        // 更新账号信息
        $event->admin->token = token_hash( $event->admin->id );
        $event->admin->last_login_time = time();
        $event->admin->last_login_ip = get_client_ip();
        $event->admin->lock_time = 0;
        $event->admin->save();

        $router = [];
        // 缓存服务端接口权限
        if ($role = Role::find($event->admin->role_id)) {
            $module = $role->module()->get();

            try {
                foreach ($module as $item) {
                    if (!empty($item->server_router)) {
                        $array = explode('.', $item->server_router);
                        $controller = $array[0];
                        $action = $array[1];
                        if ($action == 'index' && $item->extend == Module::EXTEND_ON) {
                            $router[$controller]['extend'] = true;
                        }
                        $router[$controller][] = $action;
                    }
                }
            } catch(\Exception $e) {
                throw new AppException('服务端路由设置错误');
            }
        }
        // 缓存用户数据
        $data = [
            'id' => $event->admin->id,
            'router' => $router
        ];
        Cache::store('file')->put($event->admin->token, $data, 3600 * 24);
    }
}
