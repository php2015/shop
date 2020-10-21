<?php

namespace App\Logics\Api;

use App\Models\Checkin as CheckinModel;
use App\Logics\Admin\Setting;
use App\Exceptions\AppException;
use App\Helper\Date;
use DB;
use Log;

class Checkin extends CheckinModel
{
    const CHECKED_IN = '今日已签到';

    public static function calendar()
    {
        $setting = Setting::getInstance('app.points')->fetch();
        $pointsSetting = $setting['checkin'];
        $days = 1;
        if ($yesterday = self::yesterdayCheckin()) {
            $days = $yesterday->days + 1;
        }
        $active = $days % 7 == 0 ? 6 : $days % 7 -1;
        if (!$today = self::todayCheckin()) {
            $active -= 1;
            $days -= 1;
        }
        foreach($pointsSetting as $key => $value) {
            $points = $value;
            if (!empty($yesterday)) {
                if ($yesterday->days >= 7) {
                    $points = $pointsSetting[6];
                } else {
                    $points = $value;
                }
            }
            $list[$key]['text'] = '+' . $points;
//            $list[$key]['text'] = $days > 7 ? $pointsSetting[6] : $value;
        }
        $data['points'] = User::model()->points;
        $data['today'] = $today ? 1 : 0;
        $data['days'] = $days;
        $data['active'] = $active;
        $data['calendar'] = $list;
        return $data;
    }

    public static function saveData()
    {
        if ($today = self::todayCheckin()) {
            throw new AppException(self::CHECKED_IN);
        }

        try {
            DB::beginTransaction();
            $setting = Setting::getInstance('app.points')->fetch();
            $pointsSetting = $setting['checkin'];
            $days = 0;
            if ($yesterday = self::yesterdayCheckin()) {
                $days = $yesterday->days;
            }

            if ($days >= 7) {
                $points = (int) $pointsSetting[6];
            } else {
                $points = (int) $pointsSetting[ $days == 0 ? 0 : ($days % 7 == 0 ? 6 : $days % 7) ];
            }

            User::model()->checkin()
                ->save(
                    new static([
                        'days' => $days + 1,
                        'checkin_time' => time()
                    ])
                );
            Points::record($points, Points::TYPE['CHECKIN']);
            DB::commit();
            return $points;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    /**
     * 今日签到记录
     * @return mixed
     */
    public static function todayCheckin()
    {
        $today = Date::today();

        return User::model()->checkin()
            ->whereBetween('checkin_time', [
                $today['start'],
                $today['end']
            ])
            ->first();
    }

    /**
     * 昨日签到记录
     * @return mixed
     */
    public static function yesterdayCheckin()
    {
        $yesterday = Date::yesterday();

        return User::model()->checkin()
            ->whereBetween('checkin_time', [
                $yesterday['start'],
                $yesterday['end']
            ])
            ->first();
    }
}
