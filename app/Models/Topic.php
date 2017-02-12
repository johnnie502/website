<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;

class Topic extends Model
{
    use Traits\TopicOperation, SoftDeletes, Taggable;

    protected $dates = ['deleted_at'];
    protected $fillable = ['title'];
}
