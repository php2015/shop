<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\ArticleCategory;

class ArticleCategoryController extends Controller
{
    public function index()
    {
        $this->renderSuccess(ArticleCategory::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => ArticleCategory::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'category_name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (ArticleCategory::add($this->request->all())) {
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
            ArticleCategory::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'category_name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (ArticleCategory::edit( $this->request->all() )) {
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

        if (ArticleCategory::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (ArticleCategory::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}