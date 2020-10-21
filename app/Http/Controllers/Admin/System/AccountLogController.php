<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\AdminLog;

class AccountLogController extends Controller
{
    public function index()
    {
        $this->renderSuccess(AdminLog::getList());
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (AdminLog::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}