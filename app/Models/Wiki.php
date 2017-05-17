<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Cviebrock\EloquentTaggable\Taggable;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Overtrue\LaravelFollow\Traits\CanBeFavorited;
use Ghanem\Rating\Traits\Ratingable as Rating;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wiki extends Model
{
    use Traits\WikiOperation, Moderatable, Rating, CanBeLiked, CanBeFavorited, SoftDeletes, Taggable;

    protected $table = 'wikis';
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