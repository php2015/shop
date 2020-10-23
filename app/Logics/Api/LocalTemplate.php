<?php

namespace App\Logics\Api;

use App\Models\LocalTemplate as LocalTemplateModel;

class LocalTemplate extends LocalTemplateModel
{
    public static function getFee(int $id, float $weight, $logistics)
    {
        if (empty($logistics) ) {
            return 0;
        }

        $detail = self::detail($id);
        $distance = StoreAddress::getShipmentMinDistance($logistics->lon, $logistics->lat);
        $total = $detail->method == 10 ? $distance : $weight;
        $result = null;
        foreach($detail->item as $item) {
            // 是否在配送范围
            if ($total >= $item->min && $total <= $item->max) {
                $result = $item->fee;
            }
        }
        if (empty($result)) {
            return null;
        }
        return $result;
    }

    public static function detail(int $id)
    {
        return self::with('item')
            ->findOrFail($id);
    }
}