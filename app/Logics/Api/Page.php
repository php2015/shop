<?php

namespace App\Logics\Api;

use App\Models\Page as PageModel;
use Cache;

class Page extends PageModel
{
    public static function fetch(int $id)
    {
        $key = 'page_' . $id;
        return Cache::store('file')->rememberForever($key, function () use ($id) {
            return self::where([
                'id' => $id,
                'status' => self::STATUS_ON
            ])->first();
        });
    }
}
