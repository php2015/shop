<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Order;
use App\Logics\Admin\Express;

class OrderController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Order::getList());
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Order::detail($this->request->get('id'))
        );
    }

    public function shipment()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess([
            'express' => Express::getAll(),
            'detail' => Order::detail($this->request->get('id'))
        ]);
    }

    public function doShipment()
    {
        $this->validate([
            'id' => 'required|int',
            'express_id' => 'required|int',
            'contact' => 'required|string',
            'phone' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'detail' => 'required|string',
        ]);

        if (Order::shipment( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doPrints()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Order::prints( $this->request->get('id') )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
