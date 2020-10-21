<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\CouponReceive;

class CouponReceiveController extends Controller
{
    public function index()
    {
        $this->renderSuccess(CouponReceive::getList());
    }

    public function doStatus()
    {
        $this->validate([
            'id' => 'required|int',
            'field' => 'required|string',
        ]);

        if (CouponReceive::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (CouponReceive::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}