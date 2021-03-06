<?php

namespace App\Logics\Admin;

use App\Models\Express as ExpressModel;
use Illuminate\Http\Request;

class Express extends ExpressModel
{
    public static function getList()
    {
        $request = Request::capture();
        $company = $request->get('company');
        $code = $request->get('code');
        $sort = $request->get('sort');

        $filter = [];
        !empty($company) && $filter[] = ['company', 'like', "%$company%"];
        !empty($code) && $filter[] = ['code', 'like', "%$code%"];
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
        return self::orderBy('sort', 'asc')->get();
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    /**
     * @param array $data
     * @return bool
     */
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