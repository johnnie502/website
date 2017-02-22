<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use Traits\PostOperation, Moderatable, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['content'];

    /* 
      * Get post assoc topic.
      */
    public function topic()
    {
        return $this->belongsTo('App\Models\Topic', 'topic');
    }

    /*
      * Get post assoc user.
      */
    public function user()
    {
    	return $this->belongsTo('App\Models\User, 'user');
    }
}
