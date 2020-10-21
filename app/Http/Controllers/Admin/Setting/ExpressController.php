<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Express;

class ExpressController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Express::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Express::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'company' => 'required|string',
            'code' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Express::add($this->request->all())) {
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
            Express::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'company' => 'required|string',
            'code' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Express::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Express::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}