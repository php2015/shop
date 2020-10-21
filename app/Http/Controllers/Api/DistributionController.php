<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\DistributionBonus;
use App\Logics\Api\DistributionCash;
use App\Logics\Api\User;
use App\Logics\Api\Setting;
use App\Logics\Api\Invite;
use App\Logics\Api\Distribution;

class DistributionController extends Controller
{
    public function index()
    {
        $user = User::model();
        $total = DistributionBonus::income(); // 总额
        $tellered = DistributionBonus::expenses(); // 已提
        $delay = DistributionBonus::delay(); // 未到期的
        $bonus = $user->bonus - $delay; // 可提 = 余额 - 锁定中 - 未到期
        $setting = Setting::getInstance('market.distribution')->fetch();
        $messageSetting = Setting::getInstance('message.wxapp')->fetch();
        $template = Setting::getTemplateByKeys($messageSetting, ['DISTRIBUTION_AUTH']);

        $this->renderSuccess([
            'total' => $total,
            'tellered' => $tellered,
            'delay' => $delay,
            'bonus' => $bonus,
            'team' => Invite::getList(),
            'join' => $user->distribution,
            'template' => $template,
            'setting' => $setting,
        ]);
    }

    /**
     * 我的团队
     */
    public function team()
    {
        $this->renderSuccess(
            Invite::getList()
        );
    }

    /**
     * 分销商申请协议
     */
    public function protocol()
    {
        $setting = Setting::getInstance('market.distribution')->fetch();
        $this->renderSuccess(
            empty($setting) ? '' : $setting['content']
        );
    }

    /**
     * 申请加入分销商
     */
    public function apply()
    {
        $this->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        if (Distribution::apply($this->request->all())) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    /**
     * 提现订单
     */
    public function order()
    {
        $this->renderSuccess(
            DistributionCash::getList()
        );
    }
}
