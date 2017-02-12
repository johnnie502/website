<?php 

namespace App\Models\Traits;

use App\Models\Post;

trait PostOperation
{
    public static function createWithInput($data)
    {
        return Post::create($data);
    }

    public function updateWithInput($data)
    {
        return $this->update($data);
    }
}
