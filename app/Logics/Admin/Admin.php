<?php

namespace App\Logics\Admin;

use App\Models\Admin as AdminModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Events\Admin\LoginFailEvent;
use App\Events\Admin\LoginSuccessEvent;
use App\Helper\Tree;
use App\Models\Module;
use Cache;
use Hash;
use Event;
use DB;
use Log;

class Admin extends AdminModel
{
    const ACCOUNT_ERROR   = '用户名或密码有误，注意区分大小写。';
    const ACCOUNT_LOCK    = '账号已被锁定，请稍后再试';
    const ACCOUNT_DISABLE = '账号已被禁用，请联系管理员处理';
    const USERNAME_EXIST  = '用户名已存在';
    const PASSWORD_ERROR  = '原始密码输入错误';

    public $admin;
    public $menu;

    public function login(array $params)
    {
        Log::info('Login:' . json_encode([
                'USER' => $params['username'],
                'IP' => get_client_ip(),
            ], JSON_UNESCAPED_UNICODE) . PHP_EOL);

        $this->admin = self::where([
            'username' => $params['username']
        ])->first();

        // 用户是存在的
        if (!empty($this->admin)) {
            // 账号已被禁用
            if ($this->admin->disable === self::DISABLE_ON) {
                throw new AppException(self::ACCOUNT_DISABLE);
            }

            // 账号已被锁定
            if ($this->admin->lock_time >= time()) {
                throw new AppException(self::ACCOUNT_LOCK);
            }

            // 比对密码是否输入正确
            if (!Hash::check($params['password'], $this->admin->password)) {
                Event::dispatch(new LoginFailEvent($this->admin));
                throw new AppException(self::ACCOUNT_ERROR);
            }

            // 登录成功
            Event::dispatch(new LoginSuccessEvent($this->admin));
            $this->getMenu();
            return true;
        }
        Log::info('Login:' . json_encode([
                'USER' => $params['username'],
                'IP' => get_client_ip(),
            ]) . PHP_EOL);
        throw new AppException(self::ACCOUNT_ERROR);
    }

    public function logout()
    {
        return Cache::store('file')->delete(get_token());
    }

    /**
     * 获取用户
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
        try {
            $cache = Cache::store('file')->get( get_token() );
            return $cache['id'];
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }

    /**
     * 获取用户详细信息
     * @param int $id
     * @return mixed
     */
    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function getList()
    {
        $request = Request::capture();
        $username = $request->get('username');
        $disable = $request->get('disable');
        $sort = $request->get('sort');

        $filter = [];
        !empty($username) && $filter[] = ['username', 'like', "%$username%"];
        !empty($disable) && $filter[] = ['disable', '=', $disable];
        $order = 'id asc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with(['role:id,role_name'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function add(array $data)
    {
        if (!self::where('username', $data['username'])->first()) {
            $model = new static;
            $model->username = $data['username'];
            $model->password = Hash::make($data['password']);
            $model->realname = $data['realname'];
            $model->gender = $data['gender'];
            $model->email = $data['email'];
            $model->phone = $data['phone'];
            $model->disable = $data['disable'];
            $model->intro = $data['intro'];
            $model->role_id = $data['role_id'];
            return $model->save();
        }
        throw new AppException(self::USERNAME_EXIST);
    }

    public static function edit(array $data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $model = self::where([
            ['id', '<>', $data['id']],
            ['username', '=', $data['username'] ]
        ])->first();

        if ( !$model ) {
            return self::where(['id' => $data['id']])->update($data) > 0;
        }
        throw new AppException(self::USERNAME_EXIST);
    }

    public static function remove(string $id)
    {
        try {
			DB::beginTransaction();
            $id = explode(',', $id);
            AdminLog::whereIn('admin_id', $id)->delete();
            $result = self::destroy($id) > 0;
            DB::commit();
            return $result;
        } catch(\Exception $e) {
            DB::rollback();
			Log::error($e->getMessage() . PHP_EOL);
        }
    }

    /**
     * 修改账户信息
     *
     * @param array $data
     * @return mixed
     */
    public static function changeInfo(array $data)
    {
        return self::model()->update($data);
    }

    /**
     * 修改账户密码
     *
     * @param array $data
     * @return bool
     * @throws AppException
     */
    public static function changePassword(array $data)
    {
        $model = self::model();
        if (Hash::check($data['password'], $model->password) == true) {
            $model->password = Hash::make($data['new_password']);
            $model->save();
            return true;
        }
        throw new AppException(self::PASSWORD_ERROR);
    }

    private function getMenu()
    {
        if ($role = Role::find($this->admin->role_id)) {
            $roleModule = $role->module()->get();

            $menu = [];
            foreach ($roleModule as $item) {
                if ($item->level < Module::LEVEL_POWER) {
                    $menu[] = [
                        'id' => $item->id,
                        'parent_id' => $item->parent_id,
                        'path' => $item->client_router,
                        'meta' => [
                            'title' => $item->module_name,
                            'icon' => $item->icon,
                        ],
                    ];
                }
            }
            // 结果集生成树形菜单供前端使用
            $this->menu = Tree::make($menu);
        }
    }
}
