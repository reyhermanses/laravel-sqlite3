<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        //
        Validator::extend('date_greater_than', function ($attribute, $value, $parameters, $validator) {
            // $inserted = Carbon::parse($value)->year;
            $inserted = $value;
            $since = $parameters[0];
            return $inserted >= $since && $inserted <= Carbon::now()->year;
        });
    }
}
