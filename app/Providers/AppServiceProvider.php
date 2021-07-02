<?php

namespace App\Providers;

use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $alert_product = Product::where('is_active', true)->where('is_deleted', false)->whereColumn('alert_quantity', '>', 'qty')->count();
        View::share('alert_product', $alert_product);
    }
}
