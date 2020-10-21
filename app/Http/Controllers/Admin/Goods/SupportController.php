<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\GoodsSupport;

class SupportController extends Controller
{
    public function index()
    {
        $this->renderSuccess(GoodsSupport::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => GoodsSupport::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'support_name' => 'required|string',
            'content' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (GoodsSupport::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        $this->renderSuccess(
            GoodsSupport::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'support_name' => 'required|string',
            'content' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (GoodsSupport::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doStatus()
    {
        $this->validate([
            'id' => 'required|int',
            'field' => 'required|string',
        ]);

        if (GoodsSupport::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (GoodsSupport::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
