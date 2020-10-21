<?php

namespace App\Logics\Api;

use App\Models\Points as PointsModel;
use Illuminate\Http\Request;
use Log;

class Points extends PointsModel
{
    public static function getList()
    {
        $request = Request::capture();
        $status = $request->get('status');

        $filter[] = $status == 0 ? ['points', '>', 0] : ['points', '<', 0];
        $order = 'record_time desc';

        return User::model()->points()
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 记录积分
     *
     * @param int $points
     * @param string $intro
     * @param int $user_id
     * @return bool
     */
    public static function record(int $points, string $intro, int $user_id = 0)
    {
        try {
            if ($points != 0) {
                // 微信通知后没携带Token
                $user = $user_id > 0 ? User::find($user_id) : User::model();
                $user->points()
                    ->save(
                        new static([
                            'points' => $points,
                            'intro' => $intro,
                            'record_time' => time()
                        ])
                    );
                $user->points += $points;
                $user->save();
            }
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }
}