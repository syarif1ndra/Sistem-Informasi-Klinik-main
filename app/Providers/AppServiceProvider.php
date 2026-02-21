<?php

namespace App\Providers;

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
        // Share a dynamic layout variable with all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $layout = 'layouts.admin'; // Default fallback

            if (auth()->check() && auth()->user()->isBidan()) {
                $layout = 'layouts.bidan';
            } elseif (auth()->check() && auth()->user()->isAdmin()) {
                $layout = 'layouts.admin';
            }

            $view->with('activeLayout', $layout);
        });
    }
}
