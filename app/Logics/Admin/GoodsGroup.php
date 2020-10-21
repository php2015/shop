<?php

namespace App\Logics\Admin;

use App\Models\GoodsGroup as GroupModel;
use Illuminate\Http\Request;
use DB;
use Log;

class GoodsGroup extends GroupModel
{
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->goods()->detach();
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        $group_name = $request->get('name');
        $sort = $request->get('sort');

        $filter = [];
        !empty($group_name) && $filter[] = ['group_name', 'like', "%$group_name%"];

        $order = 'sort asc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::withCount('goods')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getAll()
    {
        return self::orderBy('sort', 'asc')
            ->get();
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        $model = new static;
        $model->group_name = $data['group_name'];
        $model->status = $data['status'];
        $model->sort = $data['sort'];
        return $model->save();
    }

    public static function edit(array $data)
    {
        $detail = self::detail($data['id']);
        $detail->group_name = $data['group_name'];
        $detail->status = $data['status'];
        $detail->sort = $data['sort'];
        return $detail->save();
    }

    public static function changeStatus(array $data)
    {
        $model = self::detail($data['id']);
        $model->{$data['field']} = $model->{$data['field']} == 10 ? 20 : 10;
        $model->save();
        return true;
    }

    public static function remove(string $id)
    {
        try {
            DB::beginTransaction();
            self::destroy(explode(',', $id)) > 0;
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
