<?php

namespace App\Http\Controllers\Admin;

use App\Logics\Admin\Pv;
use App\Logics\Admin\User;
use App\Logics\Admin\Order;
use App\Logics\Admin\Payment;
use App\Logics\Admin\Distribution;
use App\Logics\Admin\DistributionCash;

class IndexController extends Controller
{
    /**
     * 运营数据
     */
    public function market()
    {
        $date = $this->request->get('date', 0);
        //
        $pv = Pv::statistic($date);
        $order = Order::statistic($date);
        $pc = cvr($pv['current'], $order['current']); // 转化率
        $result[] = [
            'pv' => $pv,
            'order' => $order,
            'pc' => $pc
        ];
        //
        $paymentSum = Payment::sum($date);
        $paymentCount = Payment::count($date);
        $percentageCurrent = $paymentCount['current'] === 0 ? 0 : bcdiv($paymentSum['current'], $paymentCount['current'], 2);
        $percentageBefore = $paymentCount['before'] === 0 ? 0 : bcdiv($paymentSum['before'], $paymentCount['before'], 2);
        $percentage = dod($percentageCurrent, $percentageBefore);
        $up = [
            'current' => $percentageCurrent,
            'before' => $percentageBefore,
            'percentage' => $percentage
        ];
        $result[] = [
            'amount' => $paymentSum,
            'user' => $paymentCount,
            'up' => $up
        ];

        //
        $new = User::statisticNew($date);
        $old = User::statisticOld($date);
        $result[] = [
            'new' => $new,
            'old' => $old
        ];
        $this->renderSuccess($result);
    }

    /**
     * 新订单 5 条Distribution
     */
    public function order()
    {
        $this->renderSuccess(
            Order::statisticNew()
        );
    }

    /**
     * 新分销商申请 5 条
     */
    public function distribution()
    {
        $this->renderSuccess(
            Distribution::statisticNew()
        );
    }

    /**
     * 新提现申请 5 条
     */
    public function cash()
    {
        $this->renderSuccess(
            DistributionCash::statisticNew()
        );
    }

    /**
     * 销量前 15 条
     */
    public function goods()
    {
        $result = [];
        $goods = Order::top( $this->request->get('date', 0) );
        foreach ($goods as $key => $item) {
            if ($key <= 15) $result[] = $item;
        }

        $this->renderSuccess( $result );
    }
}
