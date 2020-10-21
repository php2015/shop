<?php

namespace App\Logics\Admin;

use App\Models\Page as PageModel;
use Illuminate\Http\Request;
use Cache;

class Page extends PageModel
{
    public static function getList()
    {
        $request = Request::capture();
        $title = $request->get('title');
        $intro = $request->get('intro');
        $sort = $request->get('sort');

        $filter = [];
        !empty($title) && $filter[] = ['title', 'like', "%$title%"];
        !empty($intro) && $filter[] = ['intro', 'like', "%$intro%"];
        $order = 'id desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::where($filter)
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
        $model->title = $data['title'];
        $model->intro = $data['intro'];
        $model->status = $data['status'];
        $model->sort = $data['sort'];
        $model->content = '';
        return $model->save();
    }

    public static function edit(array $data)
    {
        $detail = self::detail($data['id']);
        $detail->title = $data['title'];
        $detail->intro = $data['intro'];
        $detail->status = $data['status'];
        $detail->sort = $data['sort'];
        Cache::store('file')->forget('page_' . $detail->id);
        return $detail->save();
    }

    public static function design(array $data)
    {
        $detail = self::detail($data['id']);
        $detail->content = $data['content'];
        Cache::store('file')->forget('page_' . $detail->id);
        return $detail->save();
    }

    public static function changeStatus(array $data)
    {
        $model = self::detail($data['id']);
        $model->{$data['field']} = $model->{$data['field']} == self::STATUS_OFF ? self::STATUS_ON : self::STATUS_OFF;
        Cache::store('file')->forget('page_' . $model->id);
        $model->save();
        return true;
    }

    public static function remove(string $id)
    {
        Cache::store('file')->forget('page_' . $id);
        return self::destroy($id) > 0;
    }
}
