<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Article;
use App\Logics\Admin\ArticleCategory;

class ArticleController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Article::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'category' => ArticleCategory::getAll()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'image' => 'required|string',
            'title' => 'required|string',
        ]);

        if (Article::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $data['detail'] = Article::detail($this->request->get('id'));
        $data['category'] = ArticleCategory::getAll();
        $this->renderSuccess($data);
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'image' => 'required|string',
            'title' => 'required|string',
        ]);

        if (Article::edit( $this->request->all() )) {
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

        if (Article::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Article::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}