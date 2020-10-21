<?php

namespace App\Http\Controllers\Admin;

use App\Logics\Admin\Setting;

class SystemController extends Controller
{
    public function index()
    {
        $data = [
            'system_name' => '',
            'copyright' => '',
            'logo' => ''
        ];
        if ($info = Setting::getInstance('system.base')->fetch()) {
            $data = [
                'system_name' => $info['system_name'],
                'copyright' => $info['copyright'],
                'logo' => $info['url'],
            ];
        }
        $this->renderSuccess($data);
    }
}