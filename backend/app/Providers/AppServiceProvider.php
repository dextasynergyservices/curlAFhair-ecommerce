<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Cart;

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
        // Force HTTPS in production for all URLs including assets
        if (config('app.env') === 'production' || request()->isSecure()) {
            URL::forceScheme('https');
        }

        // Share cart count with all views
        View::composer('partials.nav', function ($view) {
            $cartCount = 0;
            
            if (auth()->check()) {
                $cart = Cart::where('user_id', auth()->id())->first();
            } else {
                $cart = Cart::where('session_id', session()->getId())->first();
            }
            
            if ($cart) {
                $cartCount = $cart->items->sum('quantity');
            }
            
            $view->with('cartCount', $cartCount);
        });
    }
}
