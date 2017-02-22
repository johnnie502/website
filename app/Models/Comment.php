<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use Traits\CommentOperation, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['content'];
}
