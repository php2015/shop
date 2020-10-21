<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Http\Request;

class Model extends EloquentModel
{
    const PAGE       = 20; // 默认每页显示记录数
    const CACHE_TIME = 100; // 默认缓存过期时间，分钟

    protected $filter = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * 获取最大排序数字并 +1
     * @return int
     */
    public static function getMaxSort()
    {
        $max = self::max('sort');
        return $max == 0 ? 100 : $max + 1;
    }

    /**
     * 根据查询提交数据，获取查询条件数组
     */
    protected function getQuery()
    {
        $request = Request::capture();
        $fields = $request->all();

        foreach ($fields as $key => $item) {
            $method = 'query_' . $key;
            if (method_exists($this, $method)) {
                $this->{$method}($item);
            }
        }
    }
}
