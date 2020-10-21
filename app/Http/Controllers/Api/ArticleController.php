<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Article;
use App\Logics\Api\ArticleBanner;
use App\Logics\Api\ArticleCategory;

class ArticleController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'banner' => ArticleBanner::getAll(),
            'category' => ArticleCategory::getAll(),
            'list' => Article::getList()
        ]);
    }

    public function list()
    {
        $this->renderSuccess(
            Article::getList()
        );
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|integer',
        ]);

        $this->renderSuccess(
            Article::detail($this->request->get('id'))
        );
    }
}