<?php

namespace App\Logics\Api;

use App\Models\ExpressTemplate as ExpressTemplateModel;

class ExpressTemplate extends ExpressTemplateModel
{
    public static function getFee(int $id, int $quantity, float $weight, $logistics)
    {
        $detail = self::detail($id);
        if (empty($logistics) || $detail->free == self::LOGISTICS_FREE_ON) {
            return 0;
        }

        $rule = null;
        foreach($detail->item as $item) {
            $list = json_decode($item->region, true);
            $citys = [];
            foreach($list as $subItem) {
                if ($subItem[1] == '市辖区') {
                    $citys[] = $subItem[0];
                } else {
                    $citys[] = $subItem[1];
                }
            }
            // 是否在配送范围
            if (in_array($logistics->city, $citys)) {
                $rule = $item;
            }
        }
        if (empty($rule)) {
            return null;
        }

        // 根据计费方式获取总件或是总重
        $total = $detail->method == 10 ? $quantity : $weight;
        // 小于首件阈值，直接返回首件费用
        if ($total <= $rule->first) {
            return $rule->first_fee;
        }

        // 中续件大于 0，有计算规则继续计算
        $additional_fee = 0.00;
        if($rule->additional > 0) {
            $additional = $total - $rule->first; // 剩余件数/重量
            // 没有超出续件阈值，首件+续件费用
            if ($additional <= $rule->additional) {
                $additional_fee = $rule->additional_fee;
            } else { // 超出续件阈值
                $additional_fee = bcdiv($rule->additional_fee, $rule->additional, 2) * $additional;
            }
        }
        return $rule->first_fee + $additional_fee;
    }

    public static function detail(int $id)
    {
        return self::with('item')
            ->findOrFail($id);
    }
}