<?php

namespace App\Logics\Admin;

use App\Models\DistributionCash as DistributionCashModel;
use Illuminate\Http\Request;
use App\Events\Cash\SuccessEvent;
use App\Events\Cash\FailEvent;
use Event;
use DB;

class DistributionCash extends DistributionCashModel
{
    public static function getList()
    {
        $request = Request::capture();
        $status = $request->get('status');
        $cash_no = $request->get('cash_no');
        $sort = $request->get('sort');
        $filter = [];

        !empty($cash_no) && $filter[] = ['cash_no', 'like', "%$cash_no%"];

        switch($status) {
            case '0':
                $filter[] = ['cash_status', '=', self::CASH_STATUS_APPLY];
                break;
            case '1':
                $filter[] = ['cash_status', '=', self::CASH_STATUS_FINISH];
                $filter[] = ['audit_status', '=', self::AUDIT_STATUS_PASS];
                break;
            case '2':
                $filter[] = ['cash_status', '=', self::CASH_STATUS_FINISH];
                $filter[] = ['audit_status', '=', self::AUDIT_STATUS_FAIL];
                break;
        }

        $order = 'cash_time desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with(['user'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with(['user'])->findOrFail($id);
    }

    public static function audit(array $data)
    {
        try {
            DB::beginTransaction();
            $model = self::detail($data['id']);
            $model->cash_status = self::CASH_STATUS_FINISH;
            $model->audit_status = $data['audit_status'];
            $model->remark = $data['remark'];
            $model->finish_time = time();
            $model->save();

            switch ($model->audit_status) {
                case self::AUDIT_STATUS_PASS:
                    Event::dispatch(new SuccessEvent($model));
                    break;
                case self::AUDIT_STATUS_FAIL:
                    Event::dispatch(new FailEvent($model));
                    break;
            }
            DB::commit();
            return true;
        } catch (\Exctption $e) {
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
        return self::where('cash_status', self::CASH_STATUS_APPLY)
            ->orderBy('cash_time', 'asc')
            ->limit(5)
            ->get();
    }
}
