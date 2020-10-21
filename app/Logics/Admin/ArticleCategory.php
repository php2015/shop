<?php

namespace App\Logics\Admin;

use App\Models\ArticleCategory as ArticleCategoryModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use DB;
use Log;

class ArticleCategory extends ArticleCategoryModel
{
    public static function getList()
    {
        $request = Request::capture();
        $category_name = $request->get('category_name');
        $sort = $request->get('sort');

        $filter = [];
        !empty($category_name) && $filter[] = ['category_name', 'like', "%$category_name%"];

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
        $model->category_name = $data['category_name'];
        $model->status = $data['status'];
        $model->sort = $data['sort'];
        return $model->save();
    }

    public static function edit(array $data)
    {
        $detail = self::detail($data['id']);
        $detail->category_name = $data['category_name'];
        $detail->status = $data['status'];
        $detail->sort = $data['sort'];
        return $detail->save();
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
