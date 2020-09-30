<?php

namespace App\Providers;

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
//        Validator::extend('images', function ($attribute, $value, $params, $validator) {
//            $images = base64_decode($value);
//            $f = finfo_open();
//            $result = finfo_buffer($f, $images, FILEINFO_MIME_TYPE);
//            return $result == 'images/png' || $result == 'images/jpg' || $result == 'images/jpeg';
//        });
//
//        Validator::extend('maxSizeMB', function ($attribute, $value, $params, $validator) {
//            $images = base64_decode($value);
//
//        });
    }
}
