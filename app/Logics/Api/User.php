<?php

namespace App\Logics\Api;

use App\Models\User as UserModel;
use App\Events\User\RegisterEvent;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Services\Wechat\Factory;
use Illuminate\Database\Eloquent\Builder;
use Cache;
use Event;
use DB;
use Log;

class User extends UserModel
{
    public $user;

    /**
     * 小程序登录
     * @return bool
     * @throws AppException
     */
    public function wechatAppLogin()
    {
        try {
            DB::beginTransaction();
            $params = Request::capture()->all();
            $wechat = Factory::getInstance('wxapp');
            $session = $wechat->getSession($params['code']);
            $info = json_decode( htmlspecialchars_decode( $params['info'] ), true );
            $info['token'] = md5($session['session_key'] . $session['openid']);
            $info['session_key'] = $session['session_key'];
            $info['unionid'] = isset($session['unionid']) ? $session['unionid'] : '';
            $info['avatar'] = $info['avatarUrl'];
            $info['nickname'] = preg_replace('/[\xf0-\xf7].{3}/', '', $info['nickName']);


            // 没有unionid，那就查询openid
            if (empty($info['unionid'])) {
                $this->user = self::whereHas('wxapp', function (Builder $query) use ($session) {
                    $query->where('openid', $session['openid']);
                }, '>', 0) ->first();
            } else {
                // 有unionid，在用户主表查询unionid
                // TODO 如果前期没有unionid，后面又申请了，那是否需要匹配之前的openid，将该条记录归入
                $this->user = self::where('unionid', $session['unionid'])->first();
            }

            if ($this->user) {
                $this->user->fill($info)->save();
            } else {
                $info['parent_id'] = (int) $params['invite'];
                $info['register_time'] = time();
                $this->user = self::create($info);
                $this->user->wxapp()->create([ 'openid' => $session['openid']]);
                Event::dispatch(new RegisterEvent($this->user));
            }

            Cache::put($info['token'], $this->user->id, 3600 * 24 * 7);
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            throw new AppException($e->getMessage());
        }
    }

    public static function detail(int $id)
    {
        return self::findOrFail( $id );
    }

    /**
     * 获取用户Eloquent
     * 自动根据请求中的 token 参数从缓存中获取账户ID
     * 并根据账户ID获取到该账户的模型
     *
     * @return mixed
     */
    public static function model()
    {
        return self::findOrFail( self::getId() );
    }

    /**
     * 根据请求中 token 参数从缓存中获取账户ID
     * @return mixed
     */
    public static function getId()
    {
        return Cache::get( get_token() );
    }
}
