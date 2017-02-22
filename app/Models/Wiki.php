<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wiki extends Model
{
    use Traits\WikiOperation, Moderatable, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['category', 'title', 'content', 'redirect'];

    /*
      * Get wikiassco users.
      */
    public function users()
    {
    	return $this->belongsTo('App\Models\Wiki', 'user');
    }

    /**
     * Get all of the wiki's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'model');
    }
}