<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Node extends Model
{
    use Traits\NodeOperation, softDeletes;

    protected $table = 'nodes';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'slug',  'description'];

    /*
      * Get node assoc topics.
      */
    public function topics()
    {
        return $this->hasMany('App\Models\Topic', 'node');
    }
}