<?php

namespace App\Logics\Admin;

use App\Models\Spec as SpecModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use DB;
use Log;

class Spec extends SpecModel
{
    const FIND_DATA = '该记录下包含了一个或多个商品，不允许删除';

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->value()->delete();
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        $name = $request->get('name');
        $sort = $request->get('sort');

        $filter = [];
        !empty($name) && $filter[] = ['name', 'like', "%$name%"];
        $order = 'sort asc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with(['value'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getAll()
    {
        return self::with(['value'])
            ->orderBy('sort', 'asc')
            ->get();
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

    public static function remove(int $id)
    {
        try {
            $model = self::detail($id);
            if ($model->skuValue()->count() > 0) {
                throw new AppException(self::FIND_DATA);
            }
            DB::beginTransaction();
            self::destroy($id);
            DB::commit();
            return true;
        } catch(AppException $e) {
            throw new AppException($e->getMessage());
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function addValue(array $data)
    {
        $model = self::detail($data['spec_id']);
        return $model->value()->create([
            'name' => $data['name']
        ]);
    }

    public static function removeValue(int $id)
    {
        $model = SpecValue::detail($id);
        if ($model->skuValue()->count() > 0) {
            throw new AppException(self::FIND_DATA);
        }
        return $model->delete();
    }
}
