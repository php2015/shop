<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Store;

class StoreController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Store::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Store::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'store_name' => 'required|string',
            'contact' => 'required|string',
            'phone' => 'required|string',
            'business' => 'required|int',
            'business_begin' => 'required|string',
            'business_end' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'lon' => 'required|string',
            'lat' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|int',
        ]);

        if (Store::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->renderSuccess(
            Store::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'store_name' => 'required|string',
            'contact' => 'required|string',
            'phone' => 'required|string',
            'business' => 'required|int',
            'business_begin' => 'required|string',
            'business_end' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'lon' => 'required|string',
            'lat' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|int',
        ]);

        if (Store::edit( $this->request->all() )) {
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

        if (Store::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        if (Store::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}