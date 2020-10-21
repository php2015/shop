<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Cart;

class CartController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'list' => Cart::getList(),
            'failure' => Cart::getFailureList(),
            'total' => Cart::getTotal()
        ]);
    }

    public function total()
    {
        $this->renderSuccess(
            Cart::getTotal()
        );
    }

    public function add()
    {
        $this->validate([
            'goods_id' => 'required|int',
            'goods_name' => 'required|string',
            'image' => 'required|string',
            'goods_sku_id' => 'required|int',
            'sales_price' => 'required|numeric',
            'quantity' => 'required|int',
        ]);

        if (Cart::add( $this->request->all() )) {
            $this->renderSuccess([], '在购物车等你哦~');
        }
        $this->renderError();
    }

    public function change()
    {
        $this->validate([
            'id' => 'required|int',
            'quantity' => 'required|int',
        ]);

        if (Cart::change( $this->request->all() )) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function clear()
    {
        if (Cart::clear()) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function remove()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Cart::remove($this->request->post('id')) === true) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}
