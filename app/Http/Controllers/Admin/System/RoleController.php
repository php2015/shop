<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Role;
use App\Logics\Admin\Module;

class RoleController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Role::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'module' => Module::getTree()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'role_name' => 'required|string',
            'module' => 'required|string',
        ]);

        $data = $this->request->all();
        $module = $data['module'];
        unset($data['module']);

        if (Role::add( $data, $module )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $result = Role::detail($this->request->get('id'));
        $data['detail'] = $result;
        $data['module'] = Module::getTree();
        $data['checked'] = array_column($result->roleModule->toArray(), 'module_id');
        $this->renderSuccess($data);
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'role_name' => 'required|string',
            'module' => 'required|string',
        ]);

        $data = $this->request->all();
        $module = $data['module'];
        unset($data['module']);

        if (Role::edit( $data, $module )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sort()
    {
        $this->renderSuccess(Module::getList());
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Role::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
