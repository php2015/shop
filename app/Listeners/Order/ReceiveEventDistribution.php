<?php

namespace App\Listeners\Order;

use App\Events\Order\ReceiveEvent;
use App\Logics\Api\Invite;
use App\Logics\Api\Setting;
use App\Logics\Api\DistributionBonus;
use App\Logics\Api\User;
use App\Models\Goods;

class ReceiveEventDistribution
{
    /**
     * 签收后处理分销分佣
     * @param ReceiveEvent $event
     */
    public function handle(ReceiveEvent $event)
    {
        $order = $event->order;
        $setting = Setting::getInstance('market.distribution')->fetch();
        $distribution_status = $setting['distribution_status'];
        $distribution_type = $setting['distribution_type'];
        $level_one = $setting['level_one'];
        $level_two = $setting['level_two'];

        // 是否开启分销
        if ($distribution_status == Setting::DISTRIBUTION) {
            // 邀请表,关系链
            $inviteList = Invite::where([
                ['user_id', '=', $order->user_id],
                ['level', '<=', Setting::DISTRIBUTION_LEVEL]
            ])
                ->orderBy('level', 'asc')
                ->get();

            // 是否有上级人员
            if (!empty($inviteList)) {
                $goodsList = $order->goods()->with(['goods', 'sku'])->get();

                foreach ($goodsList as $item) {
                    // 是否开启独立分销
                    if ($item->goods['distribution_status'] == Goods::DISTRIBUTION_STATUS_ON) {
                        $distribution_type = $item->goods['distribution_type'];
                        $level_one = $item->sku['level_one'];
                        $level_two = $item->sku['level_two'];
                    }

                    switch ($distribution_type) {
                        // 按百分比计算
                        case Setting::DISTRIBUTION_TYPE_PERCENTAGE:
                            $bonus_1 = bcmul($item['total'], bcdiv($level_one, 100, 2), 2);
                            $bonus_2 = bcmul($item['total'], bcdiv($level_two, 100, 2), 2);
                            break;

                        // 按固定金额计算
                        case Setting::DISTRIBUTION_TYPE_FIXED:
                            $bonus_1 = $level_one;
                            $bonus_2 = $level_two;
                            break;
                    }

                    foreach ($inviteList as $key => $subItem) {
                        $parent_id = $subItem['parent_id'];
                        $bonus = ${'bonus_' . ($key + 1)};
                        $user = User::find($parent_id);
                        $user->bonus += $bonus;
                        $user->save();

                        $model = new DistributionBonus;
                        $model->order_id = $order->id;
                        $model->from_id = $order->user_id;
                        $model->amount = $bonus;
                        $model->balance = $user->bonus;
                        $model->record_time = time();
                        $user->bonus()->save($model);
                    }
                }
            }
        }
    }
}
