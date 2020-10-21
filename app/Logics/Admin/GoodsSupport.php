<?php

namespace App\Logics\Admin;

use App\Models\GoodsSupport as GoodsSupportModel;
use Illuminate\Http\Request;
use DB;
use Log;

class GoodsSupport extends GoodsSupportModel
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
        $support_name = $request->get('name');
        $content = $request->get('content');
        $sort = $request->get('sort');

        $filter = [];
        !empty($support_name) && $filter[] = ['support_name', 'like', "%$support_name%"];
        !empty($content) && $filter[] = ['content', 'like', "%$content%"];
        $order = 'sort asc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getAll()
    {
        return self::where('status', self::STATUS_ON)
            ->select('id', 'support_name')
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
            DB::beginTransaction();
            self::destroy(explode(',', $id));
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
