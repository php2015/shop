<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Page;

class PageController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Page::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Page::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'title' => 'required|string',
        ]);

        if (Page::add($this->request->all())) {
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
            Page::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'title' => 'required|string',
        ]);

        if (Page::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function design()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Page::detail($this->request->get('id'))
        );
    }

    public function doDesign()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Page::design( $this->request->all() )) {
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

        if (Page::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Page::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}