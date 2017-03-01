<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use Traits\PostOperation, Moderatable, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['content'];
    protected $touches = ['topics'];

    /* 
      * Get post assoc topics.
      */
    public function topics()
    {
        return $this->belongsTo('App\Models\Topic', 'topic');
    }

    /*
      * Get post assoc users.
      */
    public function users()
    {
    	return $this->belongsTo('App\Models\User', 'user');
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'model');
    }
}
