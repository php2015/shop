<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\ArticleBanner;

class ArticleBannerController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            ArticleBanner::getList()
        );
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => ArticleBanner::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'image' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (ArticleBanner::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->renderSuccess(
            ArticleBanner::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'image' => 'required|string',
            'sort' => 'int',
        ]);

        if (ArticleBanner::edit( $this->request->all() )) {
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

        if (ArticleBanner::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        if (ArticleBanner::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}