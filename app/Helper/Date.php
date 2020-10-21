<?php

namespace App\Helper;

use Carbon\Carbon;

class Date
{
    /**
     * 返回今日开始和结束时间戳
     * @return mixed
     */
    public static function today()
    {
        $result['start'] = Carbon::today()->startOfDay()->timestamp;
        $result['end'] = Carbon::today()->endOfDay()->timestamp;
        return $result;
    }

    /**
     * 返回昨日开始和结束时间戳
     * @return mixed
     */
    public static function yesterday()
    {
        $result['start'] = Carbon::yesterday()->startOfDay()->timestamp;
        $result['end'] = Carbon::yesterday()->endOfDay()->timestamp;
        return $result;
    }

    /**
     * 返回 N天之前开始和结束时间戳
     * @param int $day
     * @return mixed
     */
    public static function beforeDay(int $num)
    {
        $result['start'] = Carbon::now()->subDays($num)->startOfDay()->timestamp;
        $result['end'] = Carbon::now()->subDays($num)->endOfDay()->timestamp;
        return $result;
    }

    /**
     * 返回本周开始和结束时间戳
     * @return mixed
     */
    public static function week()
    {
        $result['start'] = Carbon::now()->startOfWeek()->timestamp;
        $result['end'] = Carbon::now()->endOfWeek()->timestamp;
        return $result;
    }

    /**
     * 返回 N 周之前开始和结束时间戳
     * @return mixed
     */
    public static function beforeWeek(int $num)
    {
        $result['start'] = Carbon::now()->subWeeks($num)->startOfWeek()->timestamp;
        $result['end'] = Carbon::now()->subWeeks($num)->endOfWeek()->timestamp;
        return $result;
    }

    /**
     * 返回本月开始和结束时间戳
     * @return mixed
     */
    public static function month()
    {
        $result['start'] = Carbon::now()->startOfMonth()->timestamp;
        $result['end'] = Carbon::now()->endOfMonth()->timestamp;
        return $result;
    }

    /**
     * 返回 N 月开始和结束时间戳
     * @return mixed
     */
    public static function beforeMonth(int $num)
    {
        $result['start'] = Carbon::now()->subMonths($num)->startOfMonth()->timestamp;
        $result['end'] = Carbon::now()->subMonths($num)->endOfMonth()->timestamp;
        return $result;
    }

    /**
     * 返回本年开始和结束时间戳
     * @return mixed
     */
    public static function year()
    {
        $result['start'] = Carbon::now()->startOfYear()->timestamp;
        $result['end'] = Carbon::now()->endOfYear()->timestamp;
        return $result;
    }
}
