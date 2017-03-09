<?php

namespace App\Models;

use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use Traits\CommentOperation, Moderatable, SoftDeletes;

    protected $table = 'comments';
    protected $dates = ['deleted_at'];
    protected $fillable = ['content'];
    protected $touches = ['post'];

    /**
     * Get all of the owning commentable models.
     */
    public function model()
    {
        return $this->morphTo();
    }
}
