<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\StoreAddress;

class StoreAddressController extends Controller
{
    public function index()
    {
        $this->renderSuccess(StoreAddress::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => StoreAddress::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'address_name' => 'required|string',
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
            'is_fetch' => 'required|int',
            'is_shipment' => 'required|int',
        ]);

        if (StoreAddress::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->renderSuccess(
            StoreAddress::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'address_name' => 'required|string',
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
            'is_fetch' => 'required|int',
            'is_shipment' => 'required|int',
        ]);

        if (StoreAddress::edit( $this->request->all() )) {
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

        if (StoreAddress::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        if (StoreAddress::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}