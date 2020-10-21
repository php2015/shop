<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        Route::pattern('id', '[0-9]+');

        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace . '\Web')
             ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->prefix('api')
            ->namespace($this->namespace . '\Api')
            ->group(base_path('routes/api/index.php'));

        Route::middleware('api')
            ->prefix('api/admin')
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/api/admin.php'));
    }
}
