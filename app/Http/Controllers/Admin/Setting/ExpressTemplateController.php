<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\ExpressTemplate;

class ExpressTemplateController extends Controller
{
    public function index()
    {
        $this->renderSuccess(ExpressTemplate::getList());
    }

    public function all()
    {
        $this->renderSuccess(ExpressTemplate::getAll());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => ExpressTemplate::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'name' => 'required|string',
            'free' => 'required|int',
            'method' => 'required|int',
            'sort' => 'required|int',
        ]);

        if (ExpressTemplate::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);
        $detail = ExpressTemplate::detail($this->request->get('id'));
        foreach ($detail->item as $value) {
            $value->region = json_decode($value->region);
        }
        $this->renderSuccess( $detail );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'name' => 'required|string',
            'free' => 'required|int',
            'method' => 'required|int',
            'sort' => 'required|int',
        ]);

        if (ExpressTemplate::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (ExpressTemplate::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}