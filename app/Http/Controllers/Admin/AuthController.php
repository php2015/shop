<?php

namespace App\Http\Controllers\Admin;

use App\Logics\Admin\Admin;

class AuthController extends Controller
{
    public function index()
    {
        $this->validate([
            'username' => 'required|string',
            'password' => 'required|min:6|max:20'
        ]);

        $model = new Admin;
        if ($model->login($this->request->all()) === true) {
            $this->renderSuccess([
                'token' => $model->admin->token,
                'username' => $model->admin->username,
                'realname' => $model->admin->realname,
                'avatar' => $model->admin->avatar_url,
                'menu' => $model->menu
            ], '登录成功');
        }
    }

    public function logout()
    {
        if ((new Admin)->logout() === true) {
            $this->renderSuccess([], '已退出');
        }
    }
}
