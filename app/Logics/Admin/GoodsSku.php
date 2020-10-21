<?php

namespace App\Logics\Admin;

use App\Models\GoodsSku as GoodsSkuModel;

class GoodsSku extends GoodsSkuModel
{
    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }
}