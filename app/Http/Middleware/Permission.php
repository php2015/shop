<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Closure;
use Cache;

class Permission
{
    public function handle(Request $request, Closure $next)
    {
        if ($cache = Cache::store('file')->get( get_token() )) {
            $router = $cache['router'];
            $routerName = Route::getCurrentRoute()->getName();
            $array = explode('.', $routerName);
            $controller = $array[0];
            $action = $array[1];

            if (isset($router[$controller])) {
                if (isset($router[$controller]['extend'])) {
                    return $next($request);
                }
                if (in_array($action, $router[$controller])) {
                    return $next($request);
                }
            }
        }
        Response::create('无权操作', Response::HTTP_FORBIDDEN)->send();
        exit;
    }
}
