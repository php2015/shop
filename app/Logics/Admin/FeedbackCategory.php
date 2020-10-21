<?php

namespace App\Logics\Admin;

use App\Models\FeedbackCategory as FeedbackCategoryModel;
use Illuminate\Http\Request;

class FeedbackCategory extends FeedbackCategoryModel
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
        $model->sort = $data['sort'];
        return $model->save();
    }

    public static function edit(array $data)
    {
        $detail = self::detail($data['id']);
        $detail->category_name = $data['category_name'];
        $detail->sort = $data['sort'];
        return $detail->save();
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}