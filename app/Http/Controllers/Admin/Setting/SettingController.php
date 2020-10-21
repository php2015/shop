<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Setting;
use Cache;

class SettingController extends Controller
{
    public function index()
    {
        $this->validate([
            'params' => 'required|string',
        ]);

        $this->renderSuccess(
            Setting::getInstance($this->request->get('params'))->fetch()
        );
    }

    public function save()
    {
        $this->validate([
            'params' => 'required|string',
            'values' => 'required|string',
        ]);

        if (Setting::getInstance($this->request->post('params'))
            ->saveDate($this->request->post('values'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    /**
     * 清除缓存
     */
    public function flush()
    {
        $key = $this->request->post('key');

        switch ($key) {
            case 'business':
                Cache::flush();
                break;
            case 'system':
                Cache::store('file')->flush();
                break;
        }
        $this->renderSuccess();
    }
}
