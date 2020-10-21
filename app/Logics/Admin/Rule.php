<?php

namespace App\Logics\Admin;

use App\Models\Rule as RuleModel;
use Illuminate\Http\Request;

class Rule extends RuleModel
{
    public static function getList()
    {
        $request = Request::capture();
        $rule_name = $request->get('rule_name');
        $sort = $request->get('sort');

        $filter = [];
        !empty($rule_name) && $filter[] = ['rule_name', 'like', "%$rule_name%"];

        $order = 'sort asc';
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
        $model->rule_name = $data['rule_name'];
        $model->content = $data['content'];
        $model->sort = $data['sort'];
        return $model->save();
    }

    public static function edit(array $data)
    {
        $model = self::detail($data['id']);
        $model->rule_name = $data['rule_name'];
        $model->content = $data['content'];
        $model->sort = $data['sort'];
        return $model->save();
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}