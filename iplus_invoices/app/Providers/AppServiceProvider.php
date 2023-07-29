<?php

namespace App\Providers;

use App\Models\Notification;
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
        view()->composer('*', function ($view){
            $adminNotifications = Notification::where('is_seen', '0')
                ->orderBy('id', 'desc')
                ->get();
            return $view->with(compact('adminNotifications'));

        });
    }
}
