<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $cartItemCount = 0;
            if (Auth::check()) {
                $cartItemCount = Cart::where('customer_id', Auth::id())->count();
            }
            $view->with('cartItemCount', $cartItemCount);
        });
    }
}
