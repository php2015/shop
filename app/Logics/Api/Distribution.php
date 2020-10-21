<?php

namespace App\Logics\Api;

use App\Models\Distribution as DistributionModel;

class Distribution extends DistributionModel
{
    public static function apply(array $data)
    {
        (new static)->updateOrCreate(
            ['user_id' => User::getId()],
            [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'apply_status' => self::APPLY_STATUS_BEGIN,
                'audit_status' => self::AUDIT_STATUS_FAIL,
                'apply_time' => time(),
            ]
        );
        return true;
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }
}