<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\LocalTemplate;

class LocalTemplateController extends Controller
{
    public function index()
    {
        $this->renderSuccess(LocalTemplate::getList());
    }

    public function all()
    {
        $this->renderSuccess(LocalTemplate::getAll());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => LocalTemplate::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'name' => 'required|string',
            'free' => 'required|int',
            'method' => 'required|int',
            'distance' => 'required|numeric',
            'weight' => 'required|numeric',
            'sort' => 'required|int',
        ]);

        if (LocalTemplate::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);
        $detail = LocalTemplate::detail($this->request->get('id'));
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

        if (LocalTemplate::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (LocalTemplate::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}