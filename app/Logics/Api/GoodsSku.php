<?php

namespace App\Logics\Api;

use App\Models\GoodsSku as GoodsSkuModel;
use App\Exceptions\AppException;

class GoodsSku extends GoodsSkuModel
{
    const STOCK_UNDER = '该商品库存不足';

    public static function detail(int $id)
    {
        return self::with(['goods'])
            ->findOrFail( $id );
    }

    /**
     * 检查库存
     * @param int $id
     * @param int $stock
     * @return bool
     * @throws AppException
     */
    public static function checkStock(int $id, int $quantity)
    {
        $detail = self::findOrFail($id);

        if ($detail->stock < $quantity) {
            throw new AppException(self::STOCK_UNDER);
        }
        return true;
    }
}
