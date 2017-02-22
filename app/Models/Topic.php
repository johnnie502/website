<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

class Topic extends Model
{
    use Traits\TopicOperation, Moderatable, SoftDeletes, Taggable;

    protected $dates = ['deleted_at'];
    protected $fillable = ['title'];

    /*
      * Get topic assoc user.
      */
    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user');
    }

    /*
      * Get topic assoc posts.
      */
    public function post()
    {
        return $this->hasMany('App\Models\Post', 'topic');
    }    
}