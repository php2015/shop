<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Goods;
use App\Logics\Api\GoodsLike;
use App\Logics\Api\Cart;
use App\Logics\Api\Address;
use App\Logics\Api\OrderComment;

class GoodsController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Goods::getList()
        );
    }

    public function detail()
    {
        $id = $this->request->get('id');
        $detail = Goods::detail($id);
        $spec = $detail->spec;
        $spec_value = $detail->specValue;
        $spec_list = [];
        foreach ($spec as $item) {
            $spec_list[ $item['id'] ] = [
                'id' => $item['id'],
                'name' => $item['name']
            ];
            foreach ($spec_value as $sub_item) {
                $spec_list[ $sub_item['spec_id'] ]['children'][$sub_item['id']] = [
                    'id' => $sub_item['id'],
                    'name' => $sub_item['name']
                ];
            }
        }
        $spec_list = array_values($spec_list);
        foreach ($spec_list as $key => $item) {
            $spec_list[$key]['children'] = array_values($item['children']);
        }
        unset($detail->spec);
        unset($detail->specValue);
        $detail->spec = $spec_list;

        $this->renderSuccess([
            'like' => GoodsLike::isLike($id),
            'cart' => Cart::getTotal(),
            'detail' => $detail
        ]);
    }

    /**
     * 生产海报
     * @throws \App\Exceptions\AppException
     */
    public function poster()
    {
        $this->renderSuccess([
            'encode' => Goods::makePoster($this->request->get('id'))
        ]);
    }

    /**
     * 评论列表
     */
    public function comment()
    {
        $this->validate([
            'goods_id' => 'required|int',
        ]);

        $this->renderSuccess(
            OrderComment::getList()
        );
    }
}
