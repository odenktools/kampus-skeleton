<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('alpha_num_xxx', function ($attr, $value, $param, $validator) {
            return preg_match('/(^[A-Za-z0-9_ ,.]+$)+/', $value);
        });

        Validator::extend('alpha_dot', function ($attr, $value, $param, $validator) {
            return preg_match('/(^[a-z.]+$)+/', $value);
        });

        Validator::extend('alpha_num_slug', function ($attr, $value, $param, $validator) {
            return preg_match('/(^[a-z0-9-]+$)+/', $value);
        });

        Validator::extend('alpha_special', function ($attr, $value, $param, $validator) {
            return preg_match('/(^[A-Za-z0-9-( )%.,_+-]+$)+/', $value);
        });

        Validator::extend('alpha_special', function ($attr, $value, $param, $validator) {
            return preg_match('/(^[A-Za-z0-9-( )%.,_+-]+$)+/', $value);
        });

        Validator::extend('email_trust', function ($attr, $value, $param, $validator) {
            return !preg_match('/^([\w-\.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)([\w-]+\.)+[\w-]{2,4})?$/',
                $value);
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
