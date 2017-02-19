<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use Traits\PostOperation, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['content'];

    /*
      * Get topic user.
      */
    public function user()
    {
    	return $this->belongsTo('App\Models\Topic', 'user');
    }
}
