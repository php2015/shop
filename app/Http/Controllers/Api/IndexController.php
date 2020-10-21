<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Setting;
use App\Logics\Api\Pv;

class IndexController extends Controller
{
    public function index()
    {

    }

    public function entry()
    {
        $order = Setting::getInstance('app.order')->fetch();
        $location = Setting::getInstance('wechat.location')->fetch();
        Pv::entry();

        $this->renderSuccess([
            'order' => [
                'invoice' => $order['invoice']
            ],
            'location' => $location
        ]);
    }
}
