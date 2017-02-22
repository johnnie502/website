<?php 

namespace App\Models\Traits;

use App\Models\Comment;

trait CommentOperation
{
    public static function createWithInput($data)
    {
        return Comment::create($data);
    }

    public function updateWithInput($data)
    {
        return $this->update($data);
    }
}
