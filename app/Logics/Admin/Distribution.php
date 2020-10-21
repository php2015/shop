<?php

namespace App\Logics\Admin;

use App\Models\Distribution as DistributionModel;
use App\Events\Distribution\AuthEvent;
use Illuminate\Http\Request;
use Event;
use Log;
use DB;

class Distribution extends DistributionModel
{
    public static function getList()
    {
        $request = Request::capture();
        $name = $request->get('name');
        $phone = $request->get('phone');

        $filter = [];
        !empty($name) && $filter[] = ['name', 'like', "%$name%"];
        !empty($phone) && $filter[] = ['phone', 'like', "%$phone%"];
        $order = 'id desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with('user')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function auth(array $data)
    {
        try {
            DB::beginTransaction();
            $detail = self::detail($data['id']);
            $detail->apply_status = 20;
            $detail->audit_status = $data['audit_status'];
            $detail->audit_time = time();
            $detail->remark = $data['remark'];
            $detail->save();
            Event::dispatch(new AuthEvent($detail));
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }

    /**
     * 用于仪表盘，代发货订单 5 条
     * @return mixed
     */
    public static function statisticNew()
    {
        return self::where('apply_status', self::APPLY_STATUS_BEGIN)
            ->orderBy('apply_time', 'asc')
            ->limit(5)
            ->get();
    }
}