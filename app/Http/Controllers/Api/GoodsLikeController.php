<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\GoodsLike;

class GoodsLikeController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            GoodsLike::getList()
        );
    }

    public function toggle()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (GoodsLike::saveData( $this->request->post('id') )) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function remove()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (GoodsLike::remove($this->request->post('id')) === true) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}