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
      * Get wikiassco user.
      */
    public function user()
    {
    	return $this->belongsTo('App\Models\Wiki', 'user');
    }
}
