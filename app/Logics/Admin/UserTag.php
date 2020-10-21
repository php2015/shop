<?php

namespace App\Logics\Admin;

use App\Models\UserTag as UserTagModel;
use Illuminate\Http\Request;

class UserTag extends UserTagModel
{
    public static function getList()
    {
        $request = Request::capture();
        $tagName = $request->get('name');
        $sort = $request->get('sort');

        $filter = [];
        !empty($tagName) && $filter[] = ['tag_name', 'like', "%$tagName%"];
        $order = 'sort asc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::withCount('user')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getAll()
    {
        return self::select('id', 'tag_name')
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

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
