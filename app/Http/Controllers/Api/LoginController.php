<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\User;

class LoginController extends Controller
{
    /**
     * 小程序登录
     * @throws \App\Exceptions\AppException
     */
    public function index()
    {
        $model = new User;
        if ($model->wechatAppLogin() === true) {
            unset($model->user->id);
            unset($model->user->parent_id);
            unset($model->user->unionid);
            unset($model->user->register_time);
            unset($model->user->last_login_time);
            unset($model->user->last_login_ip);
            $this->renderSuccess($model->user);
        }
        $this->renderError([], '登录失败');
    }
}