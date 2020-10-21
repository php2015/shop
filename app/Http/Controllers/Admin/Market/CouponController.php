<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Coupon::getList());
    }

    public function add()
    {
        $this->renderSuccess();
    }

    public function doAdd()
    {
        $this->validate([
            'coupon_name' => 'required|string',
            'total' => 'required|int',
            'coupon_type' => 'required|int',
            'coupon_visible' => 'required|int',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric',
            'condition' => 'required|numeric',
            'expire_type' => 'required|int',
            'expire_at' => 'required|int',
            'begin_at' => 'string',
            'end_at' => 'string',
        ]);

        if (Coupon::add($this->request->all())) {
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
            Coupon::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'coupon_name' => 'required|string',
            'total' => 'required|int',
            'coupon_type' => 'required|int',
            'coupon_visible' => 'required|int',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric',
            'condition' => 'required|numeric',
            'expire_type' => 'required|int',
            'expire_at' => 'required|int',
            'begin_at' => 'string',
            'end_at' => 'string',
        ]);

        if (Coupon::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doIssue()
    {
        $this->validate([
            'coupon_name' => 'required|string',
            'group' => 'required|int',
            'coupon_type' => 'required|int',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric',
            'condition' => 'required|numeric',
            'expire_type' => 'required|int',
            'expire_at' => 'required|int',
            'begin_at' => 'string',
            'end_at' => 'string',
            'user' => 'array',
        ]);

        if (Coupon::issue( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doStatus()
    {
        $this->validate([
            'id' => 'required|int'
        ]);

        if (Coupon::changeStatus($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Coupon::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
