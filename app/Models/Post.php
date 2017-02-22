<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use Traits\PostOperation, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['content'];

    public function topic()
    {
        return $this->belongsTo('App\Models\Topic', 'topic');
    }

    /*
      * Get topic user.
      */
    public function user()
    {
    	return $this->belongsTo('App\Models\Topic', 'user');
    }
}
