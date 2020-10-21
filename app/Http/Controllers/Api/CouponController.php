<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Coupon;
use App\Logics\Api\CouponReceive;

class CouponController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Coupon::getList()
        );
    }

    public function receive()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Coupon::receiveing( $this->request->post('id') )) {
            $this->renderSuccess([], '领取成功了~');
        }
        $this->renderError();
    }

    public function mine()
    {
        $this->renderSuccess(
            CouponReceive::getList()
        );
    }
}