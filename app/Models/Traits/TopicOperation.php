<?php 

namespace App\Models\Traits;

use App\Models\Topic;

trait TopicOperation
{
    public static function createWithInput($data)
    {
        return Topic::create($data);
    }

    public function updateWithInput($data)
    {
        return $this->update($data);
    }
}
