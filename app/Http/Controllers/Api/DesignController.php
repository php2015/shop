<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Goods;
use App\Logics\Api\Coupon;
use App\Logics\Api\Page;
use App\Logics\Api\Setting;
use Log;

class DesignController extends Controller
{
    public function index()
    {
        try {
            $design = Setting::getInstance(
                'design.' . $this->request->get('page')
            )->fetch();

            foreach ($design as $item) {
                if ($item->type == 'goods') {
                    $item->data->result = Goods::getDesignGoods($item->data);
                }
                if ($item->type == 'group') {
                    $item->data->result = Goods::getDesignGoodsGroup($item->data);
                }
                if ($item->type == 'coupon') {
                    $item->data->result = Coupon::getDesignCoupon($item->data);
                }
            }
            $this->renderSuccess( $design );
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public function custom()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Page::fetch($this->request->get('id'))
        );
    }
}