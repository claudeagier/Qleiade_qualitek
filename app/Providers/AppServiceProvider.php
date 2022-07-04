<?php

namespace App\Providers;

use App\Observers\WealthObserver;
use App\Models\Wealth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        ////it works
        if ($this->app->isLocal()) {
            //DOC: register ideHelper
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //DOC: Corrige  SQLSTATE[42000]: Syntax error or access violation: 1071 La clé est trop longue. Longueur maximale: 1000
        Schema::defaultStringLength(191);
        
        //DOC: to switch beetween languages
        view()->composer('partials.language_switcher', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        //DOC: to register observer
        Wealth::observe(WealthObserver::class);
    }
}
