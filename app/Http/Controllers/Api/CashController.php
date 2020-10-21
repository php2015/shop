<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\DistributionBonus;
use App\Logics\Api\DistributionCash;
use App\Logics\Api\User;
use App\Logics\Api\Setting;

class CashController extends Controller
{
    public function index()
    {
        $user = User::model();
        $delay = DistributionBonus::delay(); // 当前锁定金额
        $bonus = $user->bonus - $delay; // 可提

        $this->renderSuccess([
            'bonus' => $bonus, // 可提
            'setting' => Setting::getInstance('finance.cash')->fetch()
        ]);
    }

    public function apply()
    {
        $this->validate([
            'amount' => 'required|numeric',
        ]);

        if (DistributionCash::apply($this->request->post('amount'))) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function order()
    {
        $this->renderSuccess(
            DistributionCash::getList()
        );
    }
}
