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
      * Get topic assoc node.
      */
    public function nodes()
    {
      return $this->belongsTo('App\Models\Node', 'node');
    }

    /*
      * Get topic assoc user.
      */
    public function users()
    {
    	return $this->belongsTo('App\Models\User', 'user');
    }

    /*
      * Get topic assoc posts.
      */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'topic');
    }    
}