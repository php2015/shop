<?php

namespace App\Logics\Admin;

use App\Models\Unit as UnitModel;
use Illuminate\Http\Request;

class Unit extends UnitModel
{
    public static function getList()
    {
        $request = Request::capture();
        $unit = $request->get('name');
        $sort = $request->get('sort');

        $filter = [];
        !empty($unit) && $filter[] = ['unit', 'like', "%$unit%"];
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
        return self::select('id', 'unit')
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
