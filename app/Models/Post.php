<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use Traits\PostOperation, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['content'];
}
