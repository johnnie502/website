<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use Traits\CommentOperation, Moderatable, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['content'];
}
