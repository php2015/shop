<?php

namespace App\Logics\Admin;

use App\Models\Store as StoreModel;
use Illuminate\Http\Request;

class Store extends StoreModel
{
    public static function getList()
    {
        $request = Request::capture();
        $store_name = $request->get('name');
        $sort = $request->get('sort');

        $filter = [];
        !empty($store_name) && $filter[] = ['store_name', 'like', "%$store_name%"];
        $order = 'id desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getAll()
    {
        return self::all(['id', 'store_name']);
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        return (new static($data))
            ->save();
    }

    public static function edit(array $data)
    {
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