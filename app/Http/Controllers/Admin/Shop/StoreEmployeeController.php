<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\StoreEmployee;

class StoreEmployeeController extends Controller
{
    public function index()
    {
        $this->renderSuccess(StoreEmployee::getList());
    }

    public function add()
    {
        $this->renderSuccess();
    }

    public function doAdd()
    {
        $this->validate([
            'user' => 'required|array',
            'name' => 'required|string',
            'phone' => 'required|string',
            'verify' => 'required|int',
            'status' => 'required|int',
        ]);

        if (StoreEmployee::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            StoreEmployee::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'user' => 'required|array',
            'name' => 'required|string',
            'phone' => 'required|string',
            'verify' => 'required|int',
            'status' => 'required|int',
        ]);

        if (StoreEmployee::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doStatus()
    {
        $this->validate([
            'id' => 'required|int',
            'field' => 'required|string',
        ]);

        if (StoreEmployee::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        if (StoreEmployee::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}