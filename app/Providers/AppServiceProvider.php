<?php

namespace App\Providers;

use App;
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
