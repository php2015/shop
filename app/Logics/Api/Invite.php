<?php

namespace App\Logics\Api;

use App\Models\Invite as InviteModel;
use App\Services\Poster\Factory as PosterFactory;
use App\Services\Wechat\Factory as WechatFactory;
use App\Exceptions\AppException;
use App\Models\Setting;
use Illuminate\Http\Request;

class Invite extends InviteModel
{
    public static function getList()
    {
        $request = Request::capture();
        $user = User::model();
        $filter[] = ['parent_id', '=', $user->id];
        $filter[] = ['level', '<=', Setting::DISTRIBUTION_LEVEL];

        $order = 'invite_time desc';

        return self::with(['user'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 邀请人数合计
     * @return mixed
     */
    public static function count()
    {
        return self::where([
            'parent_id' =>  User::getId(),
            'level' => 1
        ])->count();
    }


    public static function makePoster(string $bgImage)
    {
        $user = User::model();
        $scene = "u=$user->id";
        $avatar = $user->avatar;
        $setting = Setting::getInstance('app.invite')->fetch();
        $title = $setting['title'];
        $subtitle = $setting['subtitle'];
        $arcode = WechatFactory::getInstance('wxapp')->getUnlimit($scene);
        $poster = PosterFactory::getInstance([
            'width' => 1080,
            'height' => 1920,
            'driver' => 'invite'
        ]);
        return $poster->make($bgImage, $arcode, $avatar, $title, $subtitle);
    }
}
