<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\OrderComment;

class OrderCommentController extends Controller
{
    public function index()
    {
        $this->renderSuccess(OrderComment::getList());
    }

    public function doStatus()
    {
        $this->validate([
            'id' => 'required|int',
            'field' => 'required|string',
        ]);

        if (OrderComment::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doReply()
    {
        $this->validate([
            'id' => 'required|int',
            'reply_content' => 'required|string',
        ]);

        if (OrderComment::reply($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (OrderComment::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}