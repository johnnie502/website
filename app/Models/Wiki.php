<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Wiki extends Model
{
    use Traits\WikiOperation;

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
