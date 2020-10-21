<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Admin;
use App\Logics\Admin\Role;

class AdminController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Admin::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'role' => Role::getAll()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'role_id' => 'required|int',
            'username' => 'required|string',
            'password' => 'required|min:6|max:20',
            'gender' => 'required|int',
            'email' => 'email',
            'phone' => 'regex:/^1[34578][0-9]{9}$/',
            'disable' => 'required|int',
        ]);
        if (Admin::add($this->request->all()) === true) {
            $this->renderSuccess([], '操作成功');
        }
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $data['detail'] = Admin::detail($this->request->get('id'));
        $data['role'] = Role::getAll();
        $this->renderSuccess($data);
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'username' => 'required|string',
            'password' => 'min:6|max:20',
            'gender' => 'required|int',
            'email' => 'email',
            'phone' => 'regex:/^1[34578][0-9]{9}$/',
            'disable' => 'required|int',
        ]);
        if (Admin::edit($this->request->except([
            'last_login_time', 'last_login_ip', 'url', 'timestamp'
            ])) === true) {
            $this->renderSuccess([], '操作成功');
        }
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Admin::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
