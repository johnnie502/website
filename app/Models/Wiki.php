<?php

namespace App\Models;

class Wiki extends Model
{
	use Traits\WikiOperation;
	
    protected $fillable = ['user', 'category', 'title', 'content', 'type', 'status', 'redirect', 'views', 'edits', 'lastedit', 'favicons'];
}
