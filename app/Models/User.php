<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Junaidnasir\Larainvite\InviteTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{
    use AuthenticableTrait, Traits\UserOperation, softDeletes, HasApiTokens, Notifiable, InviteTrait;

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
      * Get user signed.
      */
    public function signed()
    {
        return $this->hasMany('App\Models\Signed', 'user');
    }
}
