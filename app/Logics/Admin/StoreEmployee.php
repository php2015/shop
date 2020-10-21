<?php

namespace App\Logics\Admin;

use App\Models\StoreEmployee as StoreEmployeeModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;

class StoreEmployee extends StoreEmployeeModel
{
    const USER_EXIST  = '该用户已经绑定过了';

    public static function getList()
    {
        $request = Request::capture();
        $name = $request->get('name');
        $phone = $request->get('phone');

        $filter = [];
        !empty($name) && $filter[] = ['name', 'like', "%$name%"];
        !empty($phone) && $filter[] = ['phone', 'like', "%$phone%"];
        $order = 'id desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with('user')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with('user')->findOrFail($id);
    }

    public static function add(array $data)
    {
        $user_id = $data['user'][0]['id'];
        $model = self::where('user_id', $user_id)->first();

        if ($model) {
            throw new AppException(self::USER_EXIST);
        }
        $data['user_id'] = $user_id;
        return (new static($data))
            ->save();
    }

    public static function edit(array $data)
    {
        $user_id = $data['user'][0]['id'];
        $model = self::where([
            ['id', '<>', $data['id']],
            ['user_id', '=', $user_id ]
        ])->first();

        if ($model) {
            throw new AppException(self::USER_EXIST);
        }
        $data['user_id'] = $user_id;
        return self::detail($data['id'])
            ->fill($data)
            ->save();
    }

    public static function changeStatus(array $data)
    {
        $model = self::detail($data['id']);
        $model->{$data['field']} = $model->{$data['field']} == self::STATUS_OFF ? self::STATUS_ON : self::STATUS_OFF;
        $model->save();
        return true;
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}