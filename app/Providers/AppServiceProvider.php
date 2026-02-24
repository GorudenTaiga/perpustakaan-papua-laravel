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
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Share wishlist data with all views using main_member layout
        \Illuminate\Support\Facades\View::composer('main_member', function ($view) {
            $wishlist = [];
            if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->member) {
                $wishlist = \Illuminate\Support\Facades\Auth::user()->member->wishlist()->with('buku')->get();
            }
            $view->with('wishlist', $wishlist);
        });
    }
}
