<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Printer;

class PrinterController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Printer::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Printer::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'name' => 'required|string',
            'sn' => 'required|string',
            'label' => 'required|string',
            'sort' => 'required|int',
            'status' => 'required|int',
        ]);

        if (Printer::add($this->request->all())) {
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
            Printer::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'name' => 'required|string',
            'sn' => 'required|string',
            'label' => 'required|string',
            'sort' => 'required|int',
            'status' => 'required|int',
        ]);

        if (Printer::edit( $this->request->all() )) {
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

        if (Printer::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Printer::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
