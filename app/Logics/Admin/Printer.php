<?php

namespace App\Logics\Admin;

use App\Models\Printer as PrinterModel;
use Illuminate\Http\Request;
use App\Events\Printer\AddEvent;
use App\Events\Printer\EditEvent;
use App\Events\Printer\RemoveEvent;
use DB;
use Log;
use Event;

class Printer extends PrinterModel
{
    public static function getList()
    {
        $request = Request::capture();
        $name = $request->get('name');
        $sn = $request->get('sn');
        $label = $request->get('label');
        $sort = $request->get('sort');

        $filter = [];
        !empty($title) && $filter[] = ['title', 'like', "%$title%"];
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

    /**
     * @param array $data
     * @return bool
     */
    public static function add(array $data)
    {
        try {
            DB::beginTransaction();
            $model = self::create($data);
            Event::dispatch(new AddEvent($model));
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
            DB::beginTransaction();
            $model = self::detail($data['id']);
            $model->fill($data)->save();
            Event::dispatch(new EditEvent($model));
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function changeStatus(array $data)
    {
        $model = self::detail($data['id']);
        $model->{$data['field']} = $model->{$data['field']} == 10 ? 20 : 10;
        $model->save();
        return true;
    }

    public static function remove(string $id)
    {
        try {
            DB::beginTransaction();
        	$list = self::whereIn('id', explode(',', $id))->get();
        	foreach ($list as $item) {
        	    $item->delete();
                Event::dispatch(new RemoveEvent($item));
            }
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
