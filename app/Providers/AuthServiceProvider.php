<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\CommentPolicy;
use App\Models\Comment;
use App\Policies\WikiPolicy;
use App\Models\Wiki;
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
        Comment::class => CommentPolicy::class,
       Wiki::class => WikiPolicy::class,
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
    }
}
