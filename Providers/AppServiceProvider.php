<?php

namespace App\Providers;

use App\Http\Resource\ResourcesMap;
use App\Service\RoutePermissionCheck;
use App\Validator\CurrentPasswordRule;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('current_password', CurrentPasswordRule::class);

        $this->app->when(RoutePermissionCheck::class)
                  ->needs('$rules')
                  ->give(config('permissions'));

        $this->app->when(ResourcesMap::class)
                  ->needs('$config')
                  ->give(config('http.resources.map'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        setlocale(LC_TIME, config('app.system_locale'));

        $this->app->register(AutoMapperProvider::class);
        $this->app->register(ModuleAliasServiceProvider::class);

        if ($this->app->environment() == 'local') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
