<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App\Validator\CustomeValidator;

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
         if(\Schema::hasTable('basic_settings')){
            $setting=GET_BASIC_SETTING();
            view()->share(['setting'=>$setting]);
            $this->app->validator->resolver(function($translator, $data, $rules, $messages) {
                return new CustomeValidator($translator, $data, $rules, $messages);
            });
        }
    }
}
