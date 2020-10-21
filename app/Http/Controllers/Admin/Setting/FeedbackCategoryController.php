<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\FeedbackCategory;

class FeedbackCategoryController extends Controller
{
    public function index()
    {
        $this->renderSuccess(FeedbackCategory::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => FeedbackCategory::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'category_name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (FeedbackCategory::add($this->request->all())) {
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
            FeedbackCategory::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'category_name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (FeedbackCategory::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (FeedbackCategory::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}