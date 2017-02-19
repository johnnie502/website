<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\WikiPolicy;
use App\Models\Wiki;
use App\Policies\FilePolicy;
use App\Models\File;
use App\Policies\NodePolicy;
use App\Models\Node;
use App\Policies\PostPolicy;
use App\Models\Post;
use App\Policies\UserPolicy;
use App\Models\User;
use App\Policies\TopicPolicy;
use App\Models\Topic;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		 Wiki::class => WikiPolicy::class,
		 File::class => FilePolicy::class,
		 Node::class => NodePolicy::class,
		 Post::class => PostPolicy::class,
		 User::class => UserPolicy::class,
		 Topic::class => TopicPolicy::class,
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
