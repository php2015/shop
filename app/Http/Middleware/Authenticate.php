<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (Cache::get( get_token() ) === null) {
            Response::create('登录已过期', Response::HTTP_UNAUTHORIZED)->send();
            exit;
        }
        return $next($request);
    }
}
