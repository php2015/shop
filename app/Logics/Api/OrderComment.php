<?php

namespace App\Logics\Api;

use App\Models\OrderComment as OrderCommentModel;
use Illuminate\Http\Request;

class OrderComment extends OrderCommentModel
{
    public static function getList()
    {
        $request = Request::capture();
        $goods_id = $request->get('goods_id');
        $order = 'top desc, rate desc, comment_time desc';

        return self::with(['images', 'user'])
            ->where('goods_id', $goods_id)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }
}