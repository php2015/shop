<?php

namespace App\Logics\Admin;

use App\Models\Pv as PvModel;
use App\Helper\Date;

class Pv extends PvModel
{
    public static function statistic(int $date)
    {
        $result = [
            'current' => 0,
            'before' => 0
        ];
        switch($date) {
            case 0:
                $currentDate = Date::today();
                $beforeDate = Date::yesterday();
                break;
            case 1:
                $currentDate = Date::yesterday();
                $beforeDate = Date::beforeDay(2);
                break;
            case 2:
                $currentDate = Date::week();
                $beforeDate = Date::beforeWeek(1);
                break;
            case 3:
                $currentDate = Date::beforeWeek(1);
                $beforeDate = Date::beforeWeek(2);
                break;
            case 4:
                $currentDate = Date::month();
                $beforeDate = Date::beforeMonth(1);
                break;
            case 5:
                $currentDate = Date::beforeMonth(1);
                $beforeDate = Date::beforeMonth(2);
                break;
        }
        $current = self::whereBetween('entry_time',[$currentDate['start'], $currentDate['end']])->count();
        $before =  self::whereBetween('entry_time',[$beforeDate['start'], $beforeDate['end']])->count();
        $result['current'] = $current;
        $result['before'] = $before;
        $result['percentage'] = dod($current, $before);
        return $result;
    }
}