<?php

if (! function_exists('token_hash')) {
    function token_hash($id = '', $terminal = 'admin')
    {
        return md5(
            $id . time() . $terminal
        );
    }
}

if (! function_exists('get_token')) {
    function get_token()
    {
        $request = Illuminate\Http\Request::capture();
//    $token = $request->query('token');
//    if (empty($token)) {
//        $token = $request->input('token');
//    }
//        if (empty($token)) {
//            $token = $request->header('X-Token', '');
//        }
        return $request->header('X-Token', '');
    }
}

if (! function_exists('get_sign')) {
    function get_sign()
    {
        $request = Illuminate\Http\Request::capture();
        return $sign = $request->header('X-Sign', '');
    }
}

if (! function_exists('get_timestamp')) {
    function get_timestamp()
    {
        $request = Illuminate\Http\Request::capture();
        $timestamp = $request->query('timestamp');

        if (empty($timestamp)) {
            $timestamp = $request->input('timestamp');
        }

        return $timestamp;
    }
}

if (! function_exists('get_client_ip')) {
    function get_client_ip()
    {
        static $realip = NULL;
        if ($realip !== NULL) {
            return $realip;
        }
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach ($arr AS $ip) {
                    $ip = trim($ip);

                    if ($ip != 'unknown') {
                        $realip = $ip;

                        break;
                    }
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                if (isset($_SERVER['REMOTE_ADDR'])) {
                    $realip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $realip = '0.0.0.0';
                }
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        // 使用正则验证IP地址的有效性，防止伪造IP地址进行SQL注入攻击
        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
        return $realip;
    }
}

if (! function_exists('str_replace_first')) {
    /**
     * Replace the first occurrence of a given value in the string.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $subject
     * @return string
     */
    function str_replace_first($search, $replace, $subject)
    {
        return Str::replaceFirst($search, $replace, $subject);
    }
}

if (! function_exists('dod')) {
    /**
     * 同比计算
     *
     * @param int $current
     * @param int $before
     * @return float|int
     */
    function dod(int $current, int $before)
    {
        if ($current == $before) return 0;
        if ($before === 0) return 100;
        return bcmul(
            bcdiv(
                bcsub($current, $before, 2), $before, 2
            ), 100, 2
        );
    }
}

if (! function_exists('cvr')) {
    /**
     * 转化率计算
     *
     * @param int $click
     * @param int $value
     * @return float|int
     */
    function cvr(int $click, int $value)
    {
        if ($click == $value) return 0;
        if ($click === 0) return 100;
        return bcmul(bcdiv($value, $click, 2), 100, 2);
    }
}

if (! function_exists('get_distance')) {
    /**
     * 计算两点之间的距离
     *
     * @param $lng1
     * @param $lat1
     * @param $lng2
     * @param $lat2
     * @param int $unit m，km
     * @param int $decimal 位数
     * @return float
     */
    function get_distance($lng1, $lat1, $lng2, $lat2, $unit = 2, $decimal = 2)
    {

        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI = 3.1415926535898;

        $radLat1 = $lat1 * $PI / 180.0;
        $radLat2 = $lat2 * $PI / 180.0;

        $radLng1 = $lng1 * $PI / 180.0;
        $radLng2 = $lng2 * $PI / 180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $distance = $distance * $EARTH_RADIUS * 1000;

        if ($unit === 2) {
            $distance /= 1000;
        }

        return round($distance, $decimal);
    }
}

if (! function_exists('get_fetch_times')) {
    /**
     * 获取自提订单的自提预约时间
     *
     * @param int $today_fetch
     * @param string $business_begin
     * @param string $business_end
     * @return mixed
     */
    function get_fetch_time (int $today_fetch, string $business_begin, string $business_end)
    {
        $times[] = [
            'text' => '今日',
            'disabled' => $today_fetch == 10 ? true : false
        ];
        $times[] = [
            'text' => '明日',
            'disabled' => false
        ];
        $id = 1;
        $h = (int) date("h", time());
        foreach ($times as $key => $day) {
            for($i = 0; $i < 24; $i++) {
                if ($key == 0) {
                    if ($h < $i) {
                        $times[$key]['children'][] = [
                            'text' => $i . ':00-' . ($i + 1) . ':00',
                            'id' => $id
                        ];
                        $id++;
                    }
                } else {
                    $times[$key]['children'][] = [
                        'text' => $i . ':00-' . ($i + 1) . ':00',
                        'id' => $id
                    ];
                    $id++;
                }
            }
        }
        return $times;
    }
}

