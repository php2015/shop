<?php

namespace App\Logics\Api;

use App\Models\Rule as RuleModel;

class Rule extends RuleModel
{
    public static function getAll()
    {
        return self::select(['id', 'rule_name'])
            ->orderBy('sort', 'asc')
            ->get();
    }

    public static function detail($id)
    {
        return self::findOrFail($id);
    }
}