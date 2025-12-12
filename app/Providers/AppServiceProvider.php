<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

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
        //STAGING

        // Blade::if('user', function () {
        //     return auth()->check() && auth()->user()->user_role_id == null;
        // });

        // TEMP HIDE while DEV
        Blade::if('user', function () {
            return auth()->check() && ( Auth::user()->user_role_id == null && Auth::user()->type == "normal" && (Auth::user()->verified == -1 || Auth::user()->verified == 0 || Auth::user()->verified == 1));
        });

        Blade::if('usermember', function () {
            return auth()->check() && ((auth()->user()->user_role_id == null && Auth::user()->type == "normal" && auth()->user()->verified == -1));
        });
        Blade::if('userunverified', function () {
            return auth()->check() && ((auth()->user()->user_role_id == null && Auth::user()->type == "normal" && auth()->user()->verified == 0));
        });
        Blade::if('userverified', function () {
            return auth()->check() && ((auth()->user()->user_role_id == null && Auth::user()->type == "normal" && auth()->user()->verified == 1));
        });

        Blade::if('userverifiedunverified', function () {
            return auth()->check() && ((auth()->user()->user_role_id == null && Auth::user()->type == "normal" && (auth()->user()->verified == 0 || auth()->user()->verified == 1)));
        });

        


        // ADMIN Directives
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->user_role_id == 1 && (auth()->user()->type == "super" || auth()->user()->type == "og" || auth()->user()->type == "bdu" || auth()->user()->type == "editor");
        });

        Blade::if('adminsuper', function () {
            return auth()->check() && auth()->user()->user_role_id == 1 && auth()->user()->type == "super";
        });

        Blade::if('adminog', function () {
            return auth()->check() && auth()->user()->user_role_id == 1 && (auth()->user()->type == "og" || auth()->user()->type == "super");
        });

        Blade::if('adminbdu', function () {
            return auth()->check() && auth()->user()->user_role_id == 1 && (auth()->user()->type == "bdu" || auth()->user()->type == "super");
        });

        Blade::if('admineditor', function () {
            return auth()->check() && auth()->user()->user_role_id == 1 && (auth()->user()->type == "editor" || auth()->user()->type == "super");
        });
        
    }
}
