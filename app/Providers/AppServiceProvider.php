<?php

namespace App\Providers;

use App\Http\Controllers\WeatherController;
use GuzzleHttp\Client as GuzzleHTTP;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::withoutDoubleEncoding();
        Paginator::useBootstrapThree();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

            if (config('app.debug', false)) {
                $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            }
        }

        /** WeatherAPI */
        $this->app->when(WeatherController::class)
            ->needs(GuzzleHTTP::class)
            ->give(function () {
                return new GuzzleHTTP(
                    [
                        'base_uri' => 'https://api.checkwx.com',
                        'timeout'  => 10.0,
                        'headers'  => [
                            'X-API-KEY' => config('services.checkwx.key')
                        ]
                    ]);
            });
    }
}
