<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Unit;

class UnitController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Unit::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Unit::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'unit' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Unit::add($this->request->all())) {
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
            Unit::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'unit' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Unit::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Unit::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
