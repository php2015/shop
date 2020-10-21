<?php

namespace App\Http\Controllers\Admin;

use App\Logics\Admin\Admin;

class ProfileController extends Controller
{
    /**
     * 获取当前登录用户信息
     *
     * @throws \App\Exceptions\AppException
     */
    public function index()
    {
        $this->renderSuccess(Admin::model());
    }

    /**
     * 修改当前登录用户信息
     */
    public function info()
    {
        $this->validate([
            'realname' => 'required|string',
            'email' => 'email',
            'phone' => 'regex:/^1[34578][0-9]{9}$/'
        ]);
        if (Admin::changeInfo($this->request->only(
            ['realname', 'email', 'phone', 'remark', 'avatar']
            )) === true) {
            $this->renderSuccess([], '资料保存成功');
        }
        $this->renderError([], '操作失败');
    }

    public function password()
    {
        $this->validate([
            'password' => 'required|min:6|max:20',
            'new_password' => 'required|min:6|max:20'
        ]);

        if (Admin::changePassword($this->request->all()) === true) {
            $this->renderSuccess([], '密码修改成功');
        }
        $this->renderError([], '操作失败');
    }
}
