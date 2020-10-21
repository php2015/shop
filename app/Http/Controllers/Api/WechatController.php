<?php

namespace App\Http\Controllers\Api;

use App\Services\Wechat\Factory;
use App\Logics\Api\User;

class WechatController extends Controller
{
    public function phone()
    {
        $params = $this->request->all();
        $user = User::model();
        $phone = Factory::getInstance('wxapp')
            ->getPhone($user->session_key, $params['iv'], $params['encryptedData']);

        $this->renderSuccess($phone);
    }
}
