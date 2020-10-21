<?php

namespace App\Logics\Admin;

use App\Models\Module as ModuleModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Helper\Tree;
use DB;
use Log;

class Module extends ModuleModel
{
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->roleModule()->delete();
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        $parent_id = $request->get('parent_id');

        $filter[] = ['parent_id', '=', $parent_id];
        $order = 'sort asc';

        return self::where($filter)
            ->orderByRaw($order)
            ->get();
    }

    public static function getTree(int $selected = -1)
    {
        $data = self::orderBy('sort', 'asc')->get();
        return Tree::make($data, 0, $selected);
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        $data['level'] = self::LEVEL_DIR;
        if ($data['parent_id'] > 0) {
            $parent = self::detail($data['parent_id']);
            $data['level'] = $parent->level + 10;
        }
        if ($data['level'] > self::LEVEL_POWER) {
            throw new AppException(self::LEVEL_ERROR);
        }
        return (new static($data))
            ->save();
    }

    public static function edit(array $data)
    {
        $data['level'] = self::LEVEL_DIR;
        if ($data['parent_id'] > 0) {
            $parent = self::detail($data['parent_id']);
            $data['level'] = $parent->level + 10;
            // 不能选择自己为上级
            if ($data['parent_id'] == $data['id']) {
                throw new AppException(self::PARENT_ERROR);
            }
        }
        if ($data['level'] > self::LEVEL_POWER) {
            throw new AppException(self::LEVEL_ERROR);
        }
        return self::detail($data['id'])
            ->fill($data)
            ->save();
    }

    public static function sort(string $id)
    {
        $array = explode(',', $id);

        foreach ($array as $key => $value) {
            self::where(['id' => $value])->update(['sort' => $key]);
        }
        return true;
    }

    public static function remove(string $id)
    {
        try {
			DB::beginTransaction();
            $data = self::all();
            self::removeChildren($data, $id);
            $result = self::destroy($id) > 0;
            DB::commit();
            return $result;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function removeChildren($data, int $pid)
    {
        foreach ($data as $item) {
            if ($item->parent_id == $pid) {
                self::destroy($item->id);
                self::removeChildren($data, $item->id);
            }
        }
    }
}
