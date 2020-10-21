<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Module;

class ModuleController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Module::getTree());
    }

    public function add()
    {
        $this->renderSuccess([
            'parent' => Module::getTree()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'module_name' => 'required|string',
        ]);
        $data = $this->request->all();
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (Module::add($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $id = $this->request->get('id');
        $data['detail'] = Module::detail($id);
        $data['parent'] = Module::getTree($id);
        $this->renderSuccess($data);
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'module_name' => 'required|string',
        ]);

        $data = $this->request->all();
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (Module::edit($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sort()
    {
        $this->renderSuccess(Module::getList());
    }

    public function doSort()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Module::sort($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Module::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
