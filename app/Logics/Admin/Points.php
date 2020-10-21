<?php

namespace App\Logics\Admin;

use App\Models\Points as PointsModel;

class Points extends PointsModel
{
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
                $user = User::find($user_id);
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
