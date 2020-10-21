<?php

namespace App\Logics\Admin;

use App\Models\Category as CategoryModel;
use App\Exceptions\AppException;
use App\Helper\Tree;
use Illuminate\Http\Request;
use DB;
use Log;

class Category extends CategoryModel
{
    const LEVEL_MAX = 2;
    const LEVEL_ERROR = '最多只能添加二级';
    const PARENT_ERROR = '不能选择自己为上级';
    const FIND_DATA = '该记录下包含了一个或多个商品，不允许删除';

    public static function getList()
    {
        $request = Request::capture();
        $parent_id = $request->get('parent_id');

        $filter[] = ['parent_id', '=', $parent_id];
        $order = 'sort asc';

        return self::with('goods')
            ->where($filter)
            ->orderByRaw($order)
            ->get();
    }

    public static function getTree(int $selected = -1)
    {
        $data = self::withCount('goods')
            ->orderBy('sort', 'asc')
            ->get();

        return Tree::make($data, 0, $selected);
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        $data['level'] = 0;
        if ($data['parent_id'] > 0) {
            $parent = self::detail($data['parent_id']);
            $data['level'] = $parent->level + 1;
        }
        if ($data['level'] >= self::LEVEL_MAX) {
            throw new AppException(self::LEVEL_ERROR);
        }
        return (new static($data))
            ->save();
    }

    public static function edit(array $data)
    {
        $data['level'] = 0;
        if ($data['parent_id'] > 0) {
            $parent = self::detail($data['parent_id']);
            $data['level'] = $parent->level + 1;
            // 不能选择自己为上级
            if ($data['parent_id'] == $data['id']) {
                throw new AppException(self::PARENT_ERROR);
            }
        }
        if ($data['level'] >= self::LEVEL_MAX) {
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
            self::where(['id' => $value])->update(['sort' => $key + 100]);
        }
        return true;
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
        try {
            $model = self::detail($id);
            if ($model->goods()->count() > 0) {
                throw new AppException(self::FIND_DATA);
            }

            DB::beginTransaction();
            $data = self::all();
            self::removeChildren($data, $id);
            self::destroy($id);
            DB::commit();
            return true;
        }catch(AppException $e) {
            throw new AppException($e->getMessage());
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function removeChildren(&$data, int $pid)
    {
        foreach ($data as $item) {
            if ($item->parent_id == $pid) {
                self::destroy($item->id);
                self::removeChildren($data, $item->id);
            }
        }
    }
}
