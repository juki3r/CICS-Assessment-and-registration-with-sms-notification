<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AdminNotif;

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
        Paginator::useBootstrapFive(); // For Bootstrap 5

        View::composer('*', function ($view) {
            $notifCount = AdminNotif::where('marked', false)->count();
            $view->with('notifCount', $notifCount);
        });
    }
}
