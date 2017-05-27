<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Overtrue\LaravelFollow\Traits\CanBeFavorited;
use Jcc\LaravelVote\CanBeVoted;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use Traits\PostOperation, Moderatable, SoftDeletes, CanBeLiked, CanBeFavorited, CanBeVoted;

    protected $table = 'posts';
    protected $dates = ['deleted_at'];
    protected $fillable = ['content'];
    protected $touches = ['topics'];
    protected $vote = User::class;

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
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
