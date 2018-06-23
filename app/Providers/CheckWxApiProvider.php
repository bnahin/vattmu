<?php

namespace App\Providers;

use App\Http\Common\Bnahin\CheckWxAPI;
use Illuminate\Support\ServiceProvider;

class CheckWxApiProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Common\Bnahin\CheckWxAPI', function () {
           return new CheckWxAPI;
        });
    }
}
