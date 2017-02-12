<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Node extends Model
{
    use Traits\NodeOperation, softDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'slug',  'description'];
}
