<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\UserTag;

class TagController extends Controller
{
    public function index()
    {
        $this->renderSuccess(UserTag::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => UserTag::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'tag_name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (UserTag::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        $this->renderSuccess(
            UserTag::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'tag_name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (UserTag::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (UserTag::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
