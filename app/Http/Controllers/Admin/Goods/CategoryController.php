<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Category::getTree()
        );
    }

    public function add()
    {
        $this->renderSuccess([
            'parent' => Category::getTree(),
            'sort' => Category::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'category_name' => 'required|string',
            'sort' => 'required|int',
            'status' => 'required|int',
        ]);
        $data = $this->request->all();
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (Category::add($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $id = $this->request->get('id');
        $data['detail'] = Category::detail($id);
        $data['parent'] = Category::getTree($id);
        $this->renderSuccess($data);
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'category_name' => 'required|string',
            'sort' => 'required|int',
            'status' => 'required|int',
        ]);

        $data = $this->request->all();
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (Category::edit($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sort()
    {
        $this->renderSuccess(Category::getList());
    }

    public function doSort()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Category::sort($this->request->post('id'))) {
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

        if (Category::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Category::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
