<?php

namespace App\Models;

class Signed extends Model
{
    protected $table = 'signed';
    protected $fillable = [];

    /* 
      * Get user assoc signed.
      */
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user');
    }
}
