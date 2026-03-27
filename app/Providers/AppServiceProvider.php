<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\ServiceRequirement;

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
        Paginator::useBootstrapFive();

        View::composer('layouts.app', function ($view) {
            $serviceMenu = ServiceRequirement::whereNull('parent_id')
                ->where('status', true)
                ->with(['children' => function($q) {
                    $q->where('status', true);
                }])->get();
            $view->with('serviceMenu', $serviceMenu);
        });
    }
}
