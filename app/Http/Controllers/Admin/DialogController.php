<?php

namespace App\Http\Controllers\Admin;

use App\Logics\Admin\User;
use App\Logics\Admin\Coupon;
use App\Logics\Admin\Goods;

class DialogController extends Controller
{
    public function user()
    {
        $this->renderSuccess(User::getList());
    }

    public function coupon()
    {
        $this->renderSuccess(Coupon::getSelectList());
    }

    public function goods()
    {
        $this->renderSuccess(Goods::getSelectList());
    }
}