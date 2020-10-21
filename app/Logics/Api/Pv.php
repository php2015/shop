<?php

namespace App\Logics\Api;

use App\Models\Pv as PvModel;
use App\Helper\Date;
use Illuminate\Http\Request;

class Pv extends PvModel
{
    public static function entry()
    {
        $request = Request::capture();
        $ip = get_client_ip();
        $date = Date::today();
        $model = self::where('client_ip', $ip)
            ->whereBetween('entry_time',[$date['start'], $date['end']])
            ->first();

        if (empty($model)) {
            $model = new static;
            $model->client_ip = $ip;
            $model->entry_time = time();
            $model->user_agent = $request->header('user-agent');
            $model->save();
        }

        // 已登录的用户
        if ($userId = User::getId()) {
            $user = User::model();
            $user->last_login_time = time();
            $user->last_login_ip = $ip;
            $user->save();
        }
    }
}
