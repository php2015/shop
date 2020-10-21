<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\DistributionCash;

class CashController extends Controller
{
    public function index()
    {
        $this->renderSuccess(DistributionCash::getList());
    }

    public function audit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            DistributionCash::detail($this->request->get('id'))
        );
    }

    public function doAudit()
    {
        $this->validate([
            'id' => 'required|int',
            'audit_status' => 'required|int',
            'review' => 'string',
        ]);

        if (DistributionCash::audit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
