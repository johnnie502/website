<?php

namespace App\Providers;

use App;
use Mail;
use Queue;
use Session;
use URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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

        // Models relations.
        Relation::morphMap([
            'topics' => App\Models\Topic::class,
            'posts' => App\Models\Post::class,
            'wiki' => App\Models\Wiki::class,
        ]);

        // Set while queue failed to send a email to admin.
        Queue::failing(function (JobFailed $event) {
            // $event->connectionName
            // $event->job
            // $event->exception
            //Mail::to()
            //    ->send();
        });
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
