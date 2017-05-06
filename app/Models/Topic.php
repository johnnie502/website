<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Cviebrock\EloquentTaggable\Taggable;
use Jcc\LaravelVote\CanBeVoted;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use Traits\TopicOperation, Moderatable, SoftDeletes, Taggable, CanBeVoted;

    protected $table = 'topics';
    protected $dates = ['deleted_at','replied_at'];
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

    /**
     * Get all of the topic's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'model');
    }
}