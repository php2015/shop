<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\GoodsGroup;

class GroupController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            GoodsGroup::getList()
        );
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => GoodsGroup::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'group_name' => 'required|string',
            'sort' => 'required|int',
            'status' => 'required|int',
        ]);

        if (GoodsGroup::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            GoodsGroup::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'group_name' => 'required|string',
            'sort' => 'required|int',
            'status' => 'required|int',
        ]);

        if (GoodsGroup::edit($this->request->all())) {
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

        if (GoodsGroup::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (GoodsGroup::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
