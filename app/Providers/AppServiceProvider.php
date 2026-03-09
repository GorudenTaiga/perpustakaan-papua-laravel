<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        // Use request-scoped caching to avoid re-querying on same request
        View::composer('main_member', function ($view) {
            $wishlist = [];
            if (Auth::check() && Auth::user()->member) {
                $wishlist = once(function () {
                    return Auth::user()->member->wishlist()
                        ->select('id', 'member_id', 'buku_id')
                        ->with('buku:id,judul,slug,banner')
                        ->get();
                });
            }
            $view->with('wishlist', $wishlist);
        });
    }
}
