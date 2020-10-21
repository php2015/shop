<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Feedback;
use App\Logics\Admin\FeedbackCategory;

class FeedbackController extends Controller
{
    public function init()
    {
        $this->renderSuccess(
            [
                'category' => FeedbackCategory::getAll(),
                'list' => Feedback::getList()
            ]
        );
    }

    public function index()
    {
        $this->renderSuccess(Feedback::getList());
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Feedback::detail($this->request->get('id'))
        );
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Feedback::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
