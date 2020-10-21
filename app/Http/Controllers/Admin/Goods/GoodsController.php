<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Goods;
use App\Logics\Admin\Category;
use App\Logics\Admin\GoodsGroup;
use App\Logics\Admin\GoodsSupport;
use App\Logics\Admin\Setting;
use App\Logics\Admin\Unit;
use App\Logics\Admin\Spec;
use App\Logics\Admin\ExpressTemplate;
use App\Logics\Admin\LocalTemplate;

class GoodsController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Goods::getCount()
        );
    }

    public function list()
    {
        $this->renderSuccess(Goods::getList());
    }

    public function add()
    {
        $setting = Setting::getInstance('logistics.base')->fetch();

        $this->renderSuccess([
            'category' => Category::getTree(),
            'group' => GoodsGroup::getAll(),
            'support' => GoodsSupport::getAll(),
            'unit' => Unit::getAll(),
            'spec' => Spec::getAll(),
            'sort' => Goods::getMaxSort(),
            'express' => ExpressTemplate::getAll(),
            'local' => LocalTemplate::getAll(),
            'method' => isset($setting['method']) ? $setting['method'] : []
        ]);
    }

    public function doAdd()
    {
        $this->validate([
            'category_id' => 'required|int',
            'goods_name' => 'required|string',
            'unit' => 'required|string',
            'image' => 'required|string',
            'image_list' => 'required|array',
            'line_price' => 'required|numeric',
            'sku_type' => 'required|int',
            'sku' => 'required|array',
            'distribution_status' => 'required|int',
            'distribution_type' => 'required|int',
            'express_template_id' => 'required|int',
            'local_template_id' => 'required|int',
            'sales_init' => 'required|int',
            'sort' => 'required|int',
            'status' => 'required|int',
            //
            'group' => 'array',
            'support' => 'array',
            'content' => 'string',
        ]);

        $data = $this->request->all();
        $data['sales_time'] = empty($data['sales_time']) ? '' : $data['sales_time'];

        if (Goods::add($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess([
            'category' => Category::getTree(),
            'group' => GoodsGroup::getAll(),
            'support' => GoodsSupport::getAll(),
            'unit' => Unit::getAll(),
            'detail' => Goods::detail($this->request->get('id'))
        ]);
    }

    public function doEdit()
    {
        $this->validate([
            'id' => 'required|int',
            'goods_name' => 'required|string',
            'unit' => 'required|string',
            'category_id' => 'required|int',
            'group' => 'array',
            'support' => 'array',
        ]);

        if (Goods::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function content()
    {
        $this->renderSuccess(
            Goods::detail($this->request->get('id'))
        );
    }

    public function doContent()
    {
        $this->validate([
            'id' => 'required|int',
            'image' => 'required|string',
            'image_list' => 'required|array',
        ]);

        if (Goods::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sale()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Goods::getSale($this->request->get('id'))
        );
    }

    public function doSale()
    {
        $this->validate([
            'id' => 'required|int',
            'distribution_status' => 'required|int',
            'distribution_type' => 'required|int',
            'sku' => 'required|array',
        ]);

        if (Goods::saveSale($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function logistics()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $setting = Setting::getInstance('logistics.base')->fetch();

        $this->renderSuccess(
            [
                'express' => ExpressTemplate::getAll(),
                'local' => LocalTemplate::getAll(),
                'method' => isset($setting['method']) ? $setting['method'] : [],
                'detail' => Goods::detail($this->request->get('id'))
            ]
        );
    }

    public function doLogistics()
    {
        $this->validate([
            'id' => 'required|int',
            'express_template_id' => 'int',
            'local_template_id' => 'int',
        ]);

        if (Goods::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function other()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(Goods::detail($this->request->get('id')));
    }

    public function doOther()
    {
        $this->validate([
            'id' => 'required|int',
            'sales_init' => 'required|int',
            'sort' => 'required|int',
            'status' => 'required|int',
        ]);

        $data = $this->request->all();
        $data['sales_time'] = empty($data['sales_time']) ? '' : $data['sales_time'];

        if (Goods::edit($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doStatus()
    {
        $this->validate([
            'id' => 'required|string',
            'value' => 'required|int',
        ]);

        if (Goods::changeStatus($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function doRemove()
    {
		$this->validate([
            'id' => 'required|string',
        ]);

        if (Goods::remove($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
