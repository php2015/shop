<?php

namespace App\Logics\Admin;

use App\Models\ExpressTemplate as ExpressTemplateModel;
use Illuminate\Http\Request;
use DB;
use Log;

class ExpressTemplate extends ExpressTemplateModel
{
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->item()->delete();
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        $name = $request->get('name');
        $sort = $request->get('sort');

        $filter = [];
        !empty($name) && $filter[] = ['name', 'like', "%$name%"];
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
        return self::with('item')
            ->findOrFail($id);
    }

    public static function add(array $data)
    {
        try {
            DB::beginTransaction();
            if ($model = self::create(
                [
                    'name' => $data['name'],
                    'free' => $data['free'],
                    'method' => $data['method'],
                    'sort' => $data['sort'],
                ]
            )) {
                $model->saveItem($data['item']);
            }
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function edit(array $data)
    {
        try {
            $model = self::detail($data['id']);
            if ($model->fill(
                [
                    'name' => $data['name'],
                    'free' => $data['free'],
                    'method' => $data['method'],
                    'sort' => $data['sort'],
                ]
            )->save()) {
                $model->saveItem($data['item']);
            }
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }

    private function saveItem(array $item)
    {
        if (!empty($item)) {
            $this->item()->delete();
        }

        foreach ($item as $key => $value) {
            $this->item()->save(
                new ExpressTemplateItem(
                    [
                        'region' => json_encode($value['region']),
                        'first' => $value['first'],
                        'first_fee' => $value['first_fee'],
                        'additional' => $value['additional'],
                        'additional_fee' => $value['additional_fee'],
                    ]
                )
            );
        }
    }

    public static function remove(string $id)
    {
        try {
            DB::beginTransaction();
            $id = explode(',', $id);
            $result = self::destroy($id) > 0;
            DB::commit();
            return $result;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }
}