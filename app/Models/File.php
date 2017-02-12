<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use Traits\FileOperation, softDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'description', 'path'];
}
