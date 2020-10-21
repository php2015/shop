<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \App\Http\Middleware\XSSProtection::class,
    ];

    protected $middlewareGroups = [
        'web' => [
//            \Illuminate\Routing\Middleware\SubstituteBindings::class,
//            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
//            \Illuminate\Session\Middleware\StartSession::class,
//            \Illuminate\Session\Middleware\AuthenticateSession::class,
//            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
//            \App\Http\Middleware\EncryptCookies::class,
//            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    protected $routeMiddleware = [
//        'bindings'      => \Illuminate\Routing\Middleware\SubstituteBindings::class,
//        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
//        'verified'      => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'throttle'      => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'sign'          => \App\Http\Middleware\VerifySign::class,
        'auth'          => \App\Http\Middleware\Authenticate::class,
        'auth.admin'          => \App\Http\Middleware\AuthenticateAdmin::class,
        'permission'    => \App\Http\Middleware\Permission::class,
    ];

    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
