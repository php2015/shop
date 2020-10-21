<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Order;
use App\Logics\Api\Checkin;
use App\Logics\Api\User;

class MineController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'points' => User::model()->points,
            'checkin' => Checkin::todayCheckin() ? 1 : 0,
            'label' => Order::label()
        ]);
    }
}