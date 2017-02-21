<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

class Topic extends Model
{
    use Traits\TopicOperation, SoftDeletes, Searchable, Taggable;

    protected $dates = ['deleted_at'];
    protected $fillable = ['title'];

    /*
      * Get topic user.
      */
    public function user()
    {
    	return $this->belongsTo('App\Models\Topic', 'user');
    }
}
