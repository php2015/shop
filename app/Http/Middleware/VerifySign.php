<?php

namespace App\Http\Middleware;

use App\Exceptions\AppException;
use Illuminate\Http\Request;
use Closure;

class VerifySign
{
    public function handle(Request $request, Closure $next)
    {
        if (config('sign.verify') === true) {
            $input = $request->all();
            $sign = get_sign();
            $timestamp = floor(get_timestamp() / 1000);
            $expire = $timestamp + (5 * 60); //5分钟后接口过期

            //过期时间小于当前时间，未过期
            if ($expire >= time() && !empty($sign)) {
                $secret = config('sign.secret');
                ksort( $input );

                $params = [];
                foreach ($input as $key => $value) {
                    if (!empty($value) && !is_array($value)) {
                        $params[] = $key . '=' . $value;
                    }
                }//dump(join('&', $params));dump(md5(join('&', $params) . $secret));exit;
                if ( hash_equals(
                        md5(join('&', $params) . $secret),
                        $sign) === true ) {
                    return $next($request);
                } else {
                    throw new AppException('签名错误，拒绝访问');
                }
            }
        } else {
            return $next($request);
        }
    }
}
