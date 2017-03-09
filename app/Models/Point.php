<?php

namespace App\Models;

class Signed extends Model
{
    protected $table = 'points';
    protected $fillable = [];
    public $timestamps = false;

    /* 
      * Get user assoc signed.
      */
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user');
    }
}
