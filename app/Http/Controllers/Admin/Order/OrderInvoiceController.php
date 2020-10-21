<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\OrderInvoice;

class OrderInvoiceController extends Controller
{
    public function index()
    {
        $this->renderSuccess(OrderInvoice::getList());
    }

    public function issue()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            OrderInvoice::detail($this->request->get('id'))
        );
    }

    public function doIssue()
    {
        $this->validate([
            'id' => 'required|int',
            'tax' => 'required|numeric',
            'status' => 'required|numeric',
        ]);

        if (OrderInvoice::issue( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}