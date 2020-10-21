<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Rule;

class RuleController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Rule::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Rule::getMaxSort()
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'rule_name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Rule::add($this->request->all())) {
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
            Rule::detail($this->request->get('id'))
        );
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'rule_name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Rule::edit( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Rule::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}