<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Junaidnasir\Larainvite\InviteTrait;
use Overtrue\LaravelFollow\CanFollow;
use Overtrue\LaravelFollow\CanBeFollowed;
use Jcc\LaravelVote\Vote;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Traits\UserOperation, softDeletes, HasApiTokens, Notifiable, InviteTrait, CanFollow, CanBeFollowed, Vote;

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $fillable = ['username', 'email', 'password'];

    /*
      * Get user topics.
      */
    public function topics()
    {
    	return $this->hasMany('App\Models\Topic', 'user');
    }

    /*
      * Get user posts.
      */
    public function posts()
    {
    	return $this->hasMany('App\Models\Post', 'user');
    }

    /*
      * Get user wikis.
      */
    public function wikis()
    {
    	return $this->hasMany('App\Models\Wiki', 'user');
    }

    /* 
      * Get user points.
      */
    public function points()
    {
        return $this->hasMany('App\Models\Point', 'user');
    }
}
