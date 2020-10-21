<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Distribution;

class DistributionController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Distribution::getList()
        );
    }

    public function auth()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Distribution::detail($this->request->get('id'))
        );
    }

    public function doAuth()
    {
        $this->validate([
            'id' => 'required|int',
            'audit_status' => 'required|int',
        ]);

        if (Distribution::auth( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}