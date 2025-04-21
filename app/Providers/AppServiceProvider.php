<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer(['layouts.*', 'auth.login'], function ($view) {
            
            /** @var \Illuminate\Contracts\View\View $view */
            $view->with('setting', Setting::first());
            
        });
    }
}
