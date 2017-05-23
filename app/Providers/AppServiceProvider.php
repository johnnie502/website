<?php

namespace App\Providers;

use App;
use URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set Carbon global locale.
        $locale = strtolower(App::getLocale());
        if ($locale == 'zh-cn' || $locale == 'zh-tw') {
            $locale = 'zh';
        }
        \Carbon\Carbon::setLocale($locale);
        // FORCE USE HTTPS!!!
        if (App::environment() === 'production') {
            URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
