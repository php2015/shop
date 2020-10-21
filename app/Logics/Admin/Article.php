<?php

namespace App\Logics\Admin;

use App\Models\Article as ArticleModel;
use Illuminate\Http\Request;

class Article extends ArticleModel
{
    public static function getList()
    {
        $request = Request::capture();
        $title = $request->get('title');
        $sort = $request->get('sort');

        $filter = [];
        !empty($title) && $filter[] = ['title', 'like', "%$title%"];
        $order = 'id desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with('category')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        $model = new static;
        $model->category_id = $data['category_id'];
        $model->title = $data['title'];
        $model->subtitle = $data['subtitle'];
        $model->image = $data['image'];
        $model->style = $data['style'];
        $model->is_best = $data['is_best'];
        $model->status = $data['status'];
        $model->content = $data['content'];
        $model->release_time = time();
        return $model->save();
    }

    public static function edit(array $data)
    {
        $detail = self::detail($data['id']);
        $detail->category_id = $data['category_id'];
        $detail->title = $data['title'];
        $detail->subtitle = $data['subtitle'];
        $detail->image = $data['image'];
        $detail->style = $data['style'];
        $detail->is_best = $data['is_best']??10;
        $detail->status = $data['status'];
        $detail->content = $data['content'];
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
        return self::destroy(explode(',', $id)) > 0;
    }
}
