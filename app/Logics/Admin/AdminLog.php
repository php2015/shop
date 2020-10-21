<?php

namespace App\Logics\Admin;

use App\Models\AdminLog as AdminLogModel;
use Illuminate\Http\Request;

class AdminLog extends AdminLogModel
{
    public static function getList()
    {
        $request = Request::capture();
        $sort = $request->get('sort');

        $filter = [];
        $order = 'id desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::has('admin')
            ->with('admin')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }

    public static function write(Admin $admin, int $status = 20)
    {
        $request = Request::capture();
        $model = new static;
        $model->status = $status;
        $model->user_agent = $request->header('user-agent');
        $model->client_ip = get_client_ip();
        $model->login_time = time();
        $model->admin_id = $admin->id;
        $model->save();
    }

    /**
     * 指定之间段之内错误次数
     *
     * @param Admin $admin
     * @param int $limitedTimeLength
     */
    public static function fails(Admin $admin, int $limitedTimeLength)
    {
        // 当前时间往前数15分钟
        $start = time() - $limitedTimeLength * 60;
        return self::where([
            ['login_time', '>', $start],
            ['admin_id', '=', $admin->id],
            ['status', '=', 10]
        ])->count();
    }
}
