<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Spec;

class SpecController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Spec::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Spec::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Spec::add($this->request->all())) {
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
            Spec::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Spec::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Spec::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doAddValue()
    {
        $this->validate([
            'spec_id' => 'required|int',
            'name' => 'required|string',
        ]);

        if ($model = Spec::addValue($this->request->all())) {
            $this->renderSuccess(['id' => $model->id], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemoveValue()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Spec::removeValue($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
