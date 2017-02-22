<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

class Topic extends Model
{
    use Traits\TopicOperation, SoftDeletes, Taggable;

    protected $dates = ['deleted_at'];
    protected $fillable = ['title'];

    /*
      * Get topic user.
      */
    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'user');
    }

    /*
      * Get topic posts.
      */
    public function post()
    {
        return $this->hasMany('App\Models\Post', 'topic');
    }    
}