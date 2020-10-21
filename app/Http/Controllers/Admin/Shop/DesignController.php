<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Category;
use App\Logics\Admin\GoodsGroup;
use App\Logics\Admin\Setting;

class DesignController extends Controller
{
    public function index()
    {
        $this->validate([
            'page' => 'required|string',
        ]);

        $this->renderSuccess(
            Setting::getInstance(
                'design.' . $this->request->get('page')
            )->fetch()
        );
    }

    public function doSave()
    {
        $this->validate([
            'params' => 'required|string',
            'page' => 'required|string',
        ]);

        $result = Setting::getInstance(
            'design.' . $this->request->get('page')
        )->saveDate($this->request->post('params'));

        if ($result) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function goodsCategory()
    {
        $this->renderSuccess(
            Category::getTree()
        );
    }

    public function goodsGroup()
    {
        $this->renderSuccess(
            GoodsGroup::getAll()
        );
    }
}